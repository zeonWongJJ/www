/*
package org.wfky.app.home;

import android.content.Intent;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.TextView;
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
import com.amap.api.maps.model.BitmapDescriptor;
import com.amap.api.maps.model.BitmapDescriptorFactory;
import com.amap.api.maps.model.CameraPosition;
import com.amap.api.maps.model.LatLng;
import com.amap.api.maps.model.Marker;
import com.amap.api.maps.model.MarkerOptions;
import com.amap.api.services.core.LatLonPoint;
import com.gzqx.common.adapter.CardAdapter;
import com.gzqx.common.base.AbsBaseFragment;
import com.gzqx.common.base.AbsListFragment;
import com.gzqx.common.httpbase.net.RetrofitClient;
import com.gzqx.common.pingyin.ClearEditText;
import com.gzqx.common.widget.StatusViewLayout;

import org.wfky.app.R;
import org.wfky.app.activity.CordovaHomeActivity;
import org.wfky.app.adapter.StoreListAdapter;
import com.gzqx.common.bean.Store;
import com.view.jameson.library.CardScaleHelper;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import butterknife.BindView;
import io.reactivex.Observable;
import io.reactivex.ObservableEmitter;
import io.reactivex.ObservableOnSubscribe;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.processors.PublishProcessor;
import io.reactivex.schedulers.Schedulers;

*/
/**
 * 店铺列表
 *//*


public class HomePageFragment extends AbsBaseFragment implements LocationSource, AMapLocationListener, AMap.OnCameraChangeListener,AMap.OnMarkerClickListener {
    @BindView(R.id.recyclerView)
    protected RecyclerView mRecyclerView;

    private LatLng locationLatLng;


    private MapView mapView;
    private AMap aMap;//地图对象
    private LocationSource.OnLocationChangedListener mListener;//位置移动监听

    private AMapLocationClient locationClient = null;
    private AMapLocationClientOption locationOption = null;

    private CardAdapter adapter;
    private CardScaleHelper mCardScaleHelper = null;
    //private BitmapDescriptor markBitmap;
    private List<Marker> markerList=new ArrayList<Marker>();
    private View leftBack;
    private ClearEditText clearEditText;
    private String cityCode;

    public static HomePageFragment create(String userId, String city) {
        Bundle args = new Bundle();
        args.putString("userId", userId);
        args.putString("city", city);

        HomePageFragment fragment = new HomePageFragment();
        fragment.setArguments(args);

        return fragment;
    }
    @Override
    protected int getLayoutId() {
        return R.layout.activity_mark_search_near_store;//fragment_near_store_list
    }

    @Override
    protected void initViews(View rootView, Bundle savedInstanceState) {
        */
/*
        * Bundle args = getArguments();
    hostname = args.getString("userId");
        * *//*

        clearEditText=rootView.findViewById(R.id.filter_edit);
        leftBack=rootView.findViewById(R.id.left_back);
        leftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getActivity().finish();
            }
        });
        mapView = (MapView) rootView.findViewById(R.id.bmap_View);
        mapView.onCreate(savedInstanceState);
        if (aMap == null) {
            aMap = mapView.getMap();
            setUpMap();
        }



        final LinearLayoutManager linearLayoutManager = new LinearLayoutManager(getActivity(), LinearLayoutManager.HORIZONTAL, false);
        mRecyclerView.setLayoutManager(linearLayoutManager);
        adapter=new CardAdapter(getActivity());
        adapter.setOnItemClickListener(new CardAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(int position, View v) {
                Store store=adapter.getDataList().get(position);
                String title=store.getStore_name();
                */
/*LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()),Double.parseDouble(store.getStore_longitude()));
                setMarkenOntions(title,latLng);
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));*//*

                Intent intent=new Intent(getActivity(), CordovaHomeActivity.class);
                intent.putExtra("loadUrl","http://www.baidu.com");
                startActivity(intent);
            }
        });
        mRecyclerView.setAdapter(adapter);
        // mRecyclerView绑定scale效果
        mCardScaleHelper = new CardScaleHelper();
        mCardScaleHelper.setCurrentItemPos(0);

        mCardScaleHelper.attachToRecyclerView(mRecyclerView);
        mCardScaleHelper.setOnSmoothScrollToPositionListener(new CardScaleHelper.OnSmoothScrollToPositionListener() {
            @Override
            public void smoothScrollToCurrentPosition(int position) {
                Toast.makeText(getActivity(),"item序号"+position,Toast.LENGTH_SHORT).show();
                if(adapter.getDataList().isEmpty()){
                    return;
                }
                Store store=adapter.getDataList().get(position);
                if (store==null){
                    return;
                }
                String title=store.getStore_name();
                LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()),Double.parseDouble(store.getStore_longitude()));
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                aMap.moveCamera(CameraUpdateFactory.zoomTo(14));
            }
        });

        clearEditText.addTextChangedListener(new TextWatcher() {

            @Override
            public void onTextChanged(CharSequence s, int start, int before,
                                      int count) {
                */
/*if (TextUtils.isEmpty(s.toString())) {
                    return;
                }else {
                    if(locationLatLng==null){
                        startLocation();
                    }else {
                        dataFromNetwork();
                    }
                }*//*

            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count,
                                          int after) {

            }

            @Override
            public void afterTextChanged(Editable s) {
                if (TextUtils.isEmpty(s.toString())) {
                    return;
                }else {
                    if(locationLatLng==null){
                        startLocation();
                    }else {
                        dataFromNetwork();
                    }
                }
            }
        });
        startLocation();
    }


    //private PublishProcessor<Integer> paginator = PublishProcessor.create();
    private Disposable disposable;
    private void dataFromNetwork() {
        Map<String, String> maps = new HashMap<String, String>();
        //maps.put("citycode", cityCode);
        if(disposable!=null){
            disposable.dispose();
        }

        disposable= RetrofitClient.getInstance(getActivity()).createBaseApi().get("store_api-"+cityCode, maps, new DisposableObserver<List<Store>>() {
            @Override
            public void onNext(List<Store> storeList) {
                sortList(storeList);
            }

            @Override
            public void onError(Throwable e) {
                Log.i("bbbbbb","请求错误"+e.toString());
            }
            @Override
            public void onComplete() {

            }
        });

    }

    //门店排序
    private void sortList(final List<Store> storeList){
        Observable observable=Observable.create(new ObservableOnSubscribe() {
            @Override
            public void subscribe(ObservableEmitter e) throws Exception {
                List<Store> list=new ArrayList<Store>();
                Log.i("ccccc",storeList.size()+"storeList");
                for(Store item:storeList){
                    //float latitude=Float.parseFloat(item.getStore_latitude());

                    if(!item.getStore_latitude().isEmpty()&&!item.getStore_longitude().isEmpty()){
                        //计算p1、p2两点之间的直线距离，单位：米
                        LatLng storeLatLng=new LatLng(Double.parseDouble(item.getStore_latitude()),Double.parseDouble(item.getStore_longitude()));
                        float distance = AMapUtils.calculateLineDistance(locationLatLng,storeLatLng);
                        item.setDistance(distance);
                        list.add(item);
                    }
                }

                Collections.sort(list,new Comparator<Store>(){

                     */
/* int compare(Student o1, Student o2) 返回一个基本类型的整型，
                     * 返回负数表示：o1 小于o2，
                     * 返回0 表示：o1和o2相等，
                     * 返回正数表示：o1大于o2。*//*


                    public int compare(Store o1, Store o2) {
                        //按照学生的年龄进行升序排列
                        if(o1.getDistance() > o2.getDistance()){
                            return 1;
                        }
                        if(o1.getDistance() == o2.getDistance()){
                            return 0;
                        }
                        return -1;
                    }
                });
                e.onNext(list);
                //e.onNext(storeList);
                e.onComplete();
            }
        });
        Disposable disposable = (Disposable)observable.subscribeOn(Schedulers.io()).unsubscribeOn(Schedulers.io()).observeOn(AndroidSchedulers.mainThread()).subscribeWith(new DisposableObserver<List<Store>>() {

            @Override
            public void onError(Throwable e) {
                //reDisposable(observable);
                Log.i("ccccc",e.getMessage()+"");
            }

            @Override
            public void onComplete() {

            }

            @Override
            public void onNext(List<Store> list) {
                if(list!=null){
                    adapter.refreshData(list);
                    //默认定位第一个item
                    if(list.size()>0){
                        addMarkerOptionsByStoreList(list);
                        Store store=adapter.getDataList().get(0);
                        String title=store.getStore_name();
                        LatLng latLng = new LatLng(Double.parseDouble(store.getStore_latitude()),Double.parseDouble(store.getStore_longitude()));
                        //setMarkenOntions(title,latLng);
                        aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                        aMap.moveCamera(CameraUpdateFactory.zoomTo(14));
                    }
                }

            }
        });

    }

*/
/*locationLatLng=new LatLng(latitude,longitude);
                            refreshData();*//*


    @Override
    public void onDestroy() {
        super.onDestroy();
        destroyLocation();
        mapView.onDestroy();
    }

    */
/**
     * 初始化定位
     *
     * @since 2.8.0
     * @author hongming.wang
     *
     *//*

    private void initLocation(){
        //初始化client
        locationClient = new AMapLocationClient(getActivity().getApplicationContext());
        locationOption = getDefaultOption();
        //设置定位参数
        locationClient.setLocationOption(locationOption);
        // 设置定位监听
        locationClient.setLocationListener(this);
    }

    */
/**
     * 默认的定位参数
     * @since 2.8.0
     * @author hongming.wang
     *
     *//*

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


    */
/**
     * 获取GPS状态的字符串
     * @param statusCode GPS状态码
     * @return
     *//*

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


    */
/**
     * 开始定位
     *
     * @since 2.8.0
     * @author hongming.wang
     *
     *//*

    private void startLocation(){
        //根据控件的选择，重新设置定位参数
        initLocation();
        // 设置定位参数
        locationClient.setLocationOption(locationOption);
        // 启动定位
        locationClient.startLocation();
    }
    private void setUpMap() {
        aMap.setLocationSource(this);// 设置定位监听
        aMap.getUiSettings().setMyLocationButtonEnabled(true);// 设置默认定位按钮是否显示
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
    */
/**
     * 停止定位
     *
     * @since 2.8.0
     * @author hongming.wang
     *
     *//*

    */
/*private void stopLocation(){
        // 停止定位
        locationClient.stopLocation();
    }*//*


    */
/**
     * 销毁定位
     *
     * @since 2.8.0
     * @author hongming.wang
     *
     *//*

    private void destroyLocation(){
        if (null != locationClient) {
            */
/**
             * 如果AMapLocationClient是在当前Activity实例化的，
             * 在Activity的onDestroy中一定要执行AMapLocationClient的onDestroy
             *//*

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

    */
/**
     * 当有数据返回的时候  setLocationListener
     *
     * @param location
     *//*

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
                            dataFromNetwork();
                        }
                    } else {
                        //定位失败
                        sb.append("定位失败" + "\n");
                        sb.append("错误码:" + location.getErrorCode() + "\n");
                        sb.append("错误信息:" + location.getErrorInfo() + "\n");
                        sb.append("错误描述:" + location.getLocationDetail() + "\n");
                        if(locationLatLng!=null){
                            dataFromNetwork();
                        }
                    }
                    sb.append("***定位质量报告***").append("\n");
                    sb.append("* WIFI开关：").append(location.getLocationQualityReport().isWifiAble() ? "开启":"关闭").append("\n");
                    sb.append("* GPS状态：").append(getGPSStatusString(location.getLocationQualityReport().getGPSStatus())).append("\n");
                    sb.append("* GPS星数：").append(location.getLocationQualityReport().getGPSSatellites()).append("\n");
                    sb.append("****************").append("\n");
                    //定位之后的回调时间
                    //sb.append("回调时间: " + Utils.formatUTC(System.currentTimeMillis(), "yyyy-MM-dd HH:mm:ss") + "\n");

                    //解析定位结果，
                    //String result = sb.toString();
                    //Log.i("bbbb",""+result);
                    //tvResult.setText(result);
                } else {
                    //tvResult.setText("定位失败，loc is null");
                    getActivity().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            //mPtr.setRefreshing(false);
                        }
                    });
                }



                */
/*

                latLng = new LatLng(aMapLocation.getLatitude(), aMapLocation.getLongitude());
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                setMarkenOntions(latLng);*//*

                //search(latLng,15);              //当定位完成,获取后进行搜索

                */
/*//*
/搜索poi
                    searchPoi("", 0, currentInfo.get("cityCode"), true);
                    //latitude=41.652146#longitude=123.427205#province=辽宁省#city=沈阳市#district=浑南区#cityCode=024#adCode=210112#address=辽宁省沈阳市浑南区创新一路靠近东北大学浑南校区#country=中国#road=创新一路#poiName=东北大学浑南校区#street=创新一路#streetNum=193号#aoiName=东北大学浑南校区#poiid=#floor=#errorCode=0#errorInfo=success#locationDetail=24 #csid:1cce9508143d493182a8da7745eb07b3#locationType=5
*//*

            } else {
                String errText = "定位失败," + location.getErrorCode() + ": " + location.getErrorInfo();
                Toast.makeText(getActivity(), "定位失败，请检查您的网络.", Toast.LENGTH_LONG).show();
                Log.e("AmapErr", errText);

            }
        }
    }

    //设置我的位置
    private void setMarkenOntions(String title,LatLng latLng) {
//        aMap.clear();
        MarkerOptions markerOptions = new MarkerOptions();
        markerOptions.draggable(true);//设置Marker可拖动
        markerOptions.position(latLng);
        markerOptions.period(50);
        markerOptions.title(title);
        markerOptions.icon(
                BitmapDescriptorFactory.fromBitmap(BitmapFactory
                        .decodeResource(getResources(),
                                R.drawable.icon_mark_show)));
        markerOptions.setFlat(true);//设置marker平贴地图效果
        markerOptions.draggable(true);
        aMap.addMarker(markerOptions);
        aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
        aMap.moveCamera(CameraUpdateFactory.zoomTo(14));

        
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
    }

    @Override
    public boolean onMarkerClick(Marker marker) {
        // TODO Auto-generated method stub
        for(int i=0;i<markerList.size();i++){
            if (marker.equals(markerList.get(i))) {
                Toast.makeText(getActivity(),"点击的店铺"+marker.getTitle(),Toast.LENGTH_SHORT).show();
                //setMarkenOntions(title,marker.getPosition());
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(marker.getPosition()));
                aMap.moveCamera(CameraUpdateFactory.zoomTo(14));
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

    */
/**
     * 当滑动地图的操作
     *
     * @param cameraPosition
     *//*

    @Override
    public void onCameraChange(CameraPosition cameraPosition) {
    }

    */
/**
     * 当滑动地图结束后的操作
     * @param cameraPosition
     *//*

    @Override
    public void onCameraChangeFinish(CameraPosition cameraPosition) {
        */
/*
        今晚注释的
        if (isSertch) {
            // 如果需要搜索
            latLonPoint = new LatLonPoint(cameraPosition.target.latitude, cameraPosition.target.longitude);
            currentPage = 1;
            initSearch();
        }*//*


    }
}
*/
