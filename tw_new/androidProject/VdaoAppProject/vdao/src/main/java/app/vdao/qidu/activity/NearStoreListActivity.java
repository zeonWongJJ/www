package app.vdao.qidu.activity;

import android.content.Intent;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Toast;

import com.amap.api.location.AMapLocation;
import com.amap.api.location.AMapLocationClient;
import com.amap.api.location.AMapLocationClientOption;
import com.amap.api.location.AMapLocationListener;
import com.amap.api.location.AMapLocationQualityReport;
import com.amap.api.maps.AMap;
import com.amap.api.maps.AMapUtils;
import com.amap.api.maps.CameraUpdateFactory;
import com.amap.api.maps.LocationSource;
import com.amap.api.maps.MapView;
import com.amap.api.maps.model.BitmapDescriptorFactory;
import com.amap.api.maps.model.CameraPosition;
import com.amap.api.maps.model.LatLng;
import com.amap.api.maps.model.Marker;
import com.amap.api.maps.model.MarkerOptions;
import com.app.base.bean.Store;
import com.app.base.utils.CharacterParser;
import com.app.base.utils.IntentParams;
import com.common.lib.base.BaseApplication;
import com.common.lib.global.AppUtils;
import com.common.lib.global.PermissionUtils;
import com.common.lib.utils.SharedPreferencesUtils;
import com.common.lib.widget.ClearEditText;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.mvp.lib.base.BaseActivity;
import com.view.jameson.library.CardScaleHelper;

import app.vdao.qidu.R;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import app.vdao.qidu.adapter.CardAdapter;
import app.vdao.qidu.mvp.contract.NearStorePresenterContract;
import app.vdao.qidu.mvp.presenter.NearStorePresenterImpl;
import io.reactivex.Observable;
import io.reactivex.ObservableEmitter;
import io.reactivex.ObservableOnSubscribe;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * 附近店铺列表
 */

public class NearStoreListActivity extends BaseActivity<NearStorePresenterImpl> implements LocationSource, AMapLocationListener, AMap.OnCameraChangeListener,AMap.OnMarkerClickListener,NearStorePresenterContract.View {

    protected RecyclerView mRecyclerView;
    private LatLng locationLatLng;
    private MapView mapView;
    private AMap aMap;//地图对象
    private OnLocationChangedListener mListener;//位置移动监听
    private AMapLocationClient locationClient = null;
    private AMapLocationClientOption locationOption = null;
    private CardAdapter adapter;
    private CardScaleHelper mCardScaleHelper = null;
    //private BitmapDescriptor markBitmap;
    private List<Marker> markerList=new ArrayList<Marker>();
    private View leftBack;
    private ClearEditText clearEditText;
    private String cityCode;

    private View bmapLocalMyself;
    private int mLastPos = -1;
    /**
     * 汉字转换成拼音的类
     */
    private CharacterParser characterParser;
    private List<Store> listStores=new ArrayList<>();


    /**
     * 根据输入框中的值来过滤数据并更新ListView
     *
     * @param filterStr
     */

    private void filterData(String filterStr) {
        if(listStores.size()==0){
            //一个坑爹的问题，不保存数据，使用edittext时，listStore会被清空
            String json= (String) SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).getData("storeListJson","");
            if(!TextUtils.isEmpty(json)){
                Gson gson=new Gson();
                listStores= gson.fromJson(json, new TypeToken<List<Store>>() {}.getType());
            }
        }
        List<Store> filterDateList = new ArrayList<Store>();
        if (TextUtils.isEmpty(filterStr)) {
            filterDateList = listStores;
        } else {
            filterDateList.clear();
            for (Store store : listStores) {
                String name = store.getStore_address();
                if (name.indexOf(filterStr.toString()) != -1
                        || characterParser.getSelling(name).startsWith(
                        filterStr.toString())) {
                    filterDateList.add(store);
                }
            }
        }
        // 根据a-z进行排序
        //Collections.sort(filterDateList, pinyinComparator);
        if(filterDateList.size()>1) {
            Collections.sort(filterDateList, new Comparator<Store>() {
                public int compare(Store o1, Store o2) {
                    //按照学生的年龄进行升序排列
                    if (o1.getDistance() > o2.getDistance()) {
                        return 1;
                    }
                    if (o1.getDistance() == o2.getDistance()) {
                        return 0;
                    }
                    return -1;
                }
            });
        }
        adapter.refreshData(filterDateList);
        addMarkerOptionsByStoreList(filterDateList);
        if(filterDateList.size()>0){
            final Store store=filterDateList.get(0);
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    mRecyclerView.scrollToPosition(0);
                    String title=store.getStore_name();
                    LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()),Double.parseDouble(store.getStore_longitude()));
                    aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                    aMap.moveCamera(CameraUpdateFactory.zoomTo(12));
                }
            },300);
        }
    }

    private List<Store> filledData(List<Store> list) {
        List<Store> mSortList = new ArrayList<Store>();
        for (int i = 0; i < list.size(); i++) {
            Store store=list.get(i);
            // 汉字转换成拼音
            String pinyin = characterParser.getSelling(store.getStore_address());
            String sortString = pinyin.substring(0, 1).toUpperCase();
            // 正则表达式，判断首字母是否是英文字母
            if (sortString.matches("[A-Z]")) {
                list.get(i).setSortLetters(sortString.toUpperCase());
            } else {
                list.get(i).setSortLetters("#");
            }
            mSortList.add(store);
        }
        return mSortList;
    }


    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        mRecyclerView=findView(R.id.recyclerView);
        characterParser = CharacterParser.getInstance();
        //pinyinComparator = new PinyinStoreComparator();

        clearEditText=findView(R.id.filter_edit);
        leftBack=findView(R.id.left_back);
        leftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getActivity().finish();

            }
        });
        bmapLocalMyself=findViewById(R.id.bmap_local_myself);
        bmapLocalMyself.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(locationLatLng!=null){
                    aMap.moveCamera(CameraUpdateFactory.changeLatLng(locationLatLng));
                    aMap.moveCamera(CameraUpdateFactory.zoomTo(12));
                }
            }
        });
        mapView = (MapView)findViewById(R.id.bmap_View);
        mapView.onCreate(savedInstanceState);
        if (aMap == null) {
            aMap = mapView.getMap();
            aMap.setLocationSource(this);// 设置定位监听
            aMap.getUiSettings().setMyLocationButtonEnabled(true);// 设置默认定位按钮是否显示
            aMap.getUiSettings().setRotateGesturesEnabled(false);//屏蔽旋转手势
            aMap.setMyLocationEnabled(true);// 设置为true表示显示定位层并可触发定位，false表示隐藏定位层并不可触发定位，默认是false
            // 设置定位的类型为定位模式 ，可以由定位、跟随或地图根据面向方向旋转几种
            aMap.setMyLocationType(AMap.LOCATION_TYPE_LOCATE);

            aMap.setOnCameraChangeListener(this);
            aMap.setOnMapTouchListener(new AMap.OnMapTouchListener() {
                @Override
                public void onTouch(MotionEvent motionEvent) {
                    //isSertch = true;
                    switch (motionEvent.getAction()) {
                        case MotionEvent.ACTION_DOWN://手放下

                            break;
                        case MotionEvent.ACTION_MOVE:  //手移动

                            break;
                        case MotionEvent.ACTION_UP:
                            break;
                    }
                }
            });
        }



        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(getActivity(), LinearLayoutManager.HORIZONTAL, false);
        mRecyclerView.setLayoutManager(linearLayoutManager);
        adapter=new CardAdapter(getActivity());
        adapter.setOnItemClickListener(new CardAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(int position, View v) {
                Store store=adapter.getDataList().get(position);
                String title=store.getStore_name();
                /*LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()),Double.parseDouble(store.getStore_longitude()));
                setMarkenOntions(title,latLng);
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));*/
                Intent intent=new Intent(getActivity(), CordovaHomeActivity.class);
                intent.putExtra(IntentParams.KEY_LOAD_URL,store.getGo_url());
                intent.putExtra(IntentParams.KEY_TITLE_TYPE,1);
                startActivity(intent);
            }
        });
        mRecyclerView.setAdapter(adapter);
        // mRecyclerView绑定scale效果
        mCardScaleHelper = new CardScaleHelper();
        mCardScaleHelper.setCurrentItemPos(0);

        mCardScaleHelper.attachToRecyclerView(mRecyclerView);

        mRecyclerView.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(RecyclerView recyclerView, int newState) {
                super.onScrollStateChanged(recyclerView, newState);
                if (newState == RecyclerView.SCROLL_STATE_IDLE) {
                    if(adapter.getDataList().isEmpty()){
                        return;
                    }
                    if (mLastPos == mCardScaleHelper.getCurrentItemPos()) return;
                    mLastPos = mCardScaleHelper.getCurrentItemPos();
                    if(adapter.getDataList().size()>1) {
                        Store store = adapter.getDataList().get(mLastPos);
                        if (store == null) {
                            return;
                        }
                        LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()), Double.parseDouble(store.getStore_longitude()));
                        aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                        aMap.moveCamera(CameraUpdateFactory.zoomTo(12));
                    }else {
                        //单个item的时候 position 有bug 暂以此方式解决
                        Store store = adapter.getDataList().get(0);
                        if (store == null) {
                            return;
                        }
                        LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()), Double.parseDouble(store.getStore_longitude()));
                        aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                        aMap.moveCamera(CameraUpdateFactory.zoomTo(12));
                    }
                }
            }
        });

        clearEditText.addTextChangedListener(new TextWatcher() {
            @Override
            public void onTextChanged(CharSequence s, int start, int before,int count) {

            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count,
                                          int after) {
            }
            @Override
            public void afterTextChanged(Editable s) {
                filterData(s.toString());
            }
        });
        String[] requestPermissions = {
                PermissionUtils.PERMISSION_ACCESS_FINE_LOCATION,
                PermissionUtils.PERMISSION_ACCESS_COARSE_LOCATION
        };
        PermissionUtils.requestMultiPermissions(null,this,requestPermissions,mPermissionGrant);
        AppUtils.initGPS(getActivity());
        startLocation();

    }
    private PermissionUtils.PermissionGrant mPermissionGrant = new PermissionUtils.PermissionGrant() {
        @Override
        public void onPermissionGranted(int requestCode) {
            switch (requestCode) {
                case PermissionUtils.CODE_MULTI_PERMISSION:

                    break;
                default:
                    break;
            }
        }
    };
/*locationLatLng=new LatLng(latitude,longitude);
                            refreshData();*/

    @Override
    public void onDestroy() {
        super.onDestroy();
        destroyLocation();
        mapView.onDestroy();
    }

    /**
     * 初始化定位
     *
     * @since 2.8.0
     * @author hongming.wang
     *
     */
    private void initLocation(){
        //初始化client
        locationClient = new AMapLocationClient(getActivity().getApplicationContext());
        locationOption = getDefaultOption();
        //设置定位参数
        locationClient.setLocationOption(locationOption);
        // 设置定位监听
        locationClient.setLocationListener(this);

    }

    /**
     * 默认的定位参数
     * @since 2.8.0
     * @author hongming.wang
     *
     */
    private AMapLocationClientOption getDefaultOption(){
        AMapLocationClientOption mOption = new AMapLocationClientOption();
        mOption.setLocationMode(AMapLocationClientOption.AMapLocationMode.Hight_Accuracy);//可选，设置定位模式，可选的模式有高精度、仅设备、仅网络。默认为高精度模式
        mOption.setGpsFirst(false);//可选，设置是否gps优先，只在高精度模式下有效。默认关闭
        mOption.setHttpTimeOut(30000);//可选，设置网络请求超时时间。默认为30秒。在仅设备模式下无效
        mOption.setInterval(2000);//可选，设置定位间隔。默认为2秒
        mOption.setNeedAddress(true);//可选，设置是否返回逆地理地址信息。默认是true
        mOption.setOnceLocation(true);//可选，设置是否单次定位。默认是false
        mOption.setOnceLocationLatest(false);//可选，设置是否等待wifi刷新，默认为false.如果设置为true,会自动变为单次定位，持续定位时不要使用
        AMapLocationClientOption.setLocationProtocol(AMapLocationClientOption.AMapLocationProtocol.HTTP);//可选， 设置网络请求的协议。可选HTTP或者HTTPS。默认为HTTP
        mOption.setSensorEnable(false);//可选，设置是否使用传感器。默认是false
        mOption.setWifiScan(true); //可选，设置是否开启wifi扫描。默认为true，如果设置为false会同时停止主动刷新，停止以后完全依赖于系统刷新，定位位置可能存在误差
        mOption.setLocationCacheEnable(true); //可选，设置是否使用缓存定位，默认为true
        return mOption;
    }


    /**
     * 获取GPS状态的字符串
     * @param statusCode GPS状态码
     * @return
     */
    private String getGPSStatusString(int statusCode){
        String str = "";
        switch (statusCode){
            case AMapLocationQualityReport.GPS_STATUS_OK:
                str = "GPS状态正常";
                break;
            case AMapLocationQualityReport.GPS_STATUS_NOGPSPROVIDER:
                str = "手机中没有GPS Provider，无法进行GPS定位";
                break;
            case AMapLocationQualityReport.GPS_STATUS_OFF:
                str = "GPS关闭，建议开启GPS，提高定位质量";
                break;
            case AMapLocationQualityReport.GPS_STATUS_MODE_SAVING:
                str = "选择的定位模式中不包含GPS定位，建议选择包含GPS定位的模式，提高定位质量";
                break;
            case AMapLocationQualityReport.GPS_STATUS_NOGPSPERMISSION:
                str = "没有GPS定位权限，建议开启gps定位权限";
                break;
        }
        return str;
    }
    // 根据控件的选择，重新设置定位参数


    /**
     * 开始定位
     *
     * @since 2.8.0
     * @author hongming.wang
     *
     */
    private void startLocation(){
        //根据控件的选择，重新设置定位参数
        initLocation();
        // 启动定位
        locationClient.startLocation();
    }

    /**
     * 停止定位
     *
     * @since 2.8.0
     * @author hongming.wang
     *
     */
    /*private void stopLocation(){
        // 停止定位
        locationClient.stopLocation();
    }*/

    /**
     * 销毁定位
     *
     */
    private void destroyLocation(){
        if (null != locationClient) {
            /**
             * 如果AMapLocationClient是在当前Activity实例化的，
             * 在Activity的onDestroy中一定要执行AMapLocationClient的onDestroy
             */
            locationClient.onDestroy();
            locationClient = null;
            locationOption = null;
        }
    }




    //激活定位  LocationSource
    @Override
    public void activate(OnLocationChangedListener onLocationChangedListener) {
        mListener = onLocationChangedListener;
        if (locationClient == null) {
            locationClient = new AMapLocationClient(getActivity());
            locationOption = new AMapLocationClientOption();
            locationOption.setLocationMode(AMapLocationClientOption.AMapLocationMode.Hight_Accuracy);
            //设置定位监听
            locationClient.setLocationListener(this);
            //间隔多少秒
//            mLocationOption.setInterval(500000);
            //设置为高精度定位模式
            locationOption.setLocationMode(AMapLocationClientOption.AMapLocationMode.Hight_Accuracy);
            //获取一次定位结果：
//        //该方法默认为false。
            locationOption.setOnceLocation(true);
            //设置定位参数
            locationClient.setLocationOption(locationOption);
            // 此方法为每隔固定时间会发起一次定位请求，为了减少电量消耗或网络流量消耗，
            // 注意设置合适的定位时间的间隔（最小间隔支持为2000ms），并且在合适时间调用stopLocation()方法来取消定位请求
            // 在定位结束后，在合适的生命周期调用onDestroy()方法
            // 在单次定位情况下，定位无论成功与否，都无需调用stopLocation()方法移除请求，定位sdk内部会移除
            locationClient.startLocation();

        }

    }

    //停止定位  LocationSource
    @Override
    public void deactivate() {
        mListener = null;
        if (locationClient != null) {
            locationClient.stopLocation();
            locationClient.onDestroy();
        }
        locationClient = null;
    }

    /**
     * 当有数据返回的时候  setLocationListener
     *
     * @param location
     */
    @Override
    public void onLocationChanged(AMapLocation location) {
        if (mListener != null && location != null) {
            if (location != null
                    && location.getErrorCode() == 0) {
                //网络请求到的坐标系
                if (null != location) {
                    StringBuffer sb = new StringBuffer();
                    //errCode等于0代表定位成功，其他的为定位失败，具体的可以参照官网定位错误码说明
                    if(location.getErrorCode() == 0){
                        sb.append("定位成功" + "\n");
                        sb.append("定位类型: " + location.getLocationType() + "\n");
                        sb.append("经    度    : " + location.getLongitude() + "\n");
                        sb.append("纬    度    : " + location.getLatitude() + "\n");
                        sb.append("精    度    : " + location.getAccuracy() + "米" + "\n");
                        sb.append("提供者    : " + location.getProvider() + "\n");

                        sb.append("速    度    : " + location.getSpeed() + "米/秒" + "\n");
                        sb.append("角    度    : " + location.getBearing() + "\n");
                        // 获取当前提供定位服务的卫星个数
                        sb.append("星    数    : " + location.getSatellites() + "\n");
                        sb.append("国    家    : " + location.getCountry() + "\n");
                        sb.append("省            : " + location.getProvince() + "\n");
                        sb.append("市            : " + location.getCity() + "\n");
                        sb.append("城市编码 : " + location.getCityCode() + "\n");
                        sb.append("区            : " + location.getDistrict() + "\n");
                        sb.append("区域 码   : " + location.getAdCode() + "\n");
                        sb.append("地    址    : " + location.getAddress() + "\n");
                        sb.append("兴趣点    : " + location.getPoiName() + "\n");
                        //定位完成的时间
                        //sb.append("定位时间: " + Utils.formatUTC(location.getTime(), "yyyy-MM-dd HH:mm:ss") + "\n");
                        cityCode=location.getCityCode();
                        locationClient.stopLocation();
                        locationLatLng=new LatLng(location.getLatitude(),location.getLongitude());
                        if(locationLatLng!=null){
                            aMap.moveCamera(CameraUpdateFactory.changeLatLng(locationLatLng));
                            mPresenter.getNearStoreList(cityCode,locationLatLng);
                        }
                    } else {
                        //定位失败
                        sb.append("定位失败" + "\n");
                        sb.append("错误码:" + location.getErrorCode() + "\n");
                        sb.append("错误信息:" + location.getErrorInfo() + "\n");
                        sb.append("错误描述:" + location.getLocationDetail() + "\n");
                        if(locationLatLng!=null){
                            mPresenter.getNearStoreList(cityCode,locationLatLng);
                        }
                    }

                } else {

                }
            } else {
                String errText = "定位失败," + location.getErrorCode() + ": " + location.getErrorInfo();
                Toast.makeText(getActivity(), "定位失败，请检查您的网络.", Toast.LENGTH_LONG).show();
                Log.e("AmapErr", errText);

            }
        }
    }

    //每次重新添加marker后把定位当前位置的那个marker加上
    private void setMarkenOntions(LatLng latLng) {
//        aMap.clear();
        MarkerOptions markerOptions = new MarkerOptions();
        markerOptions.draggable(true);//设置Marker可拖动
        markerOptions.position(latLng);
        markerOptions.period(50);
//        markerOptions.title(title);
//        markerOptions.icon(
//                BitmapDescriptorFactory.fromBitmap(BitmapFactory
//                        .decodeResource(getResources(),
//                                R.drawable.icon_mark_show)));
        markerOptions.setFlat(true);//设置marker平贴地图效果
        markerOptions.draggable(true);
        aMap.addMarker(markerOptions);
        //aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
        //aMap.moveCamera(CameraUpdateFactory.zoomTo(12));
    }


    private void addMarkerOptionsByStoreList(List<Store> list){
        aMap.clear();
        ArrayList<MarkerOptions> markerOptionList = new ArrayList<MarkerOptions>();
        for(int i=0;i<list.size();i++){
            LatLng latLng = new LatLng(Double.parseDouble(list.get(i).getStore_latitude()),Double.parseDouble(list.get(i).getStore_longitude()));
            MarkerOptions markerOptions = new MarkerOptions();
            markerOptions.draggable(true);//设置Marker可拖动
            markerOptions.position(latLng);
            markerOptions.period(50);
            markerOptions.title(list.get(i).getStore_name());
            markerOptions.icon(
                    BitmapDescriptorFactory.fromBitmap(BitmapFactory
                            .decodeResource(getResources(),
                                    R.drawable.icon_mark_show)));
            markerOptions.setFlat(true);//设置marker平贴地图效果
            markerOptionList.add(markerOptions);
            //aMap.addMarker(markerOptions);
        }
        markerList=aMap.addMarkers(markerOptionList, true);
        aMap.setOnMarkerClickListener(this);// 设置点击marker事件监听器

        if(locationLatLng!=null){
            setMarkenOntions(locationLatLng);
        }
    }

    @Override
    public boolean onMarkerClick(Marker marker) {
        // TODO Auto-generated method stub
        for(int i=0;i<markerList.size();i++){
            if (marker.equals(markerList.get(i))) {
                //Toast.makeText(getActivity(),"点击的店铺"+marker.getTitle(),Toast.LENGTH_SHORT).show();
                //setMarkenOntions(title,marker.getPosition());
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(marker.getPosition()));
                aMap.moveCamera(CameraUpdateFactory.zoomTo(12));
            }
        }
        return false;
    }


    @Override
    public void onResume() {
        super.onResume();
        mapView.onResume();
    }

    @Override
    public void onPause() {
        super.onPause();
        mapView.onPause();
    }


    @Override
    public void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        mapView.onSaveInstanceState(outState);
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        //
        View view = inflater.inflate(R.layout.fragment_near_store_list, null);
        return view;
    }

    @Override
    protected NearStorePresenterImpl initPresenter() {
        return new NearStorePresenterImpl();
    }

    /**
     * 当滑动地图的操作
     *
     * @param cameraPosition
     */
    @Override
    public void onCameraChange(CameraPosition cameraPosition) {
    }

    /**
     * 当滑动地图结束后的操作
     * @param cameraPosition
     */
    @Override
    public void onCameraChangeFinish(CameraPosition cameraPosition) {

    }

    @Override
    public void showNearStoreList(List<Store> list) {
        listStores = filledData(list);
        adapter.refreshData(list);
        //默认定位第一个item
        if(list.size()>0){
            addMarkerOptionsByStoreList(list);
            final Store store=list.get(0);
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    String title=store.getStore_name();
                    LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()),Double.parseDouble(store.getStore_longitude()));
                    //setMarkenOntions(title,latLng);
                    aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                    aMap.moveCamera(CameraUpdateFactory.zoomTo(12));
                }
            },300);
        }
    }
}
