package app.vdao.qidu.activity;

import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.view.MotionEvent;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.amap.api.location.AMapLocation;
import com.amap.api.location.AMapLocationClient;
import com.amap.api.location.AMapLocationClientOption;
import com.amap.api.location.AMapLocationListener;
import com.amap.api.maps.AMap;
import com.amap.api.maps.CameraUpdateFactory;
import com.amap.api.maps.LocationSource;
import com.amap.api.maps.MapView;
import com.amap.api.maps.model.BitmapDescriptorFactory;
import com.amap.api.maps.model.CameraPosition;
import com.amap.api.maps.model.LatLng;
import com.amap.api.maps.model.MarkerOptions;
import com.gzqx.common.utils.IntentParams;

import app.vdao.qidu.R;

/**
 * 单个店铺定位
 */

public class StoreLocationActivity extends BaseMarkActivity implements LocationSource, AMapLocationListener, AMap.OnCameraChangeListener/*,AMap.OnMarkerClickListener*/ {


    private MapView mapView;
    private AMap aMap;//地图对象
    private OnLocationChangedListener mListener;//位置移动监听

    private AMapLocationClient locationClient = null;
    private AMapLocationClientOption locationOption = null;

    //private BitmapDescriptor markBitmap;
    private View leftBack;

    private double latitude,longitude;



    @Override
    protected int getContentViewID() {
        return R.layout.activity_location_store;//fragment_near_store_list
    }

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        latitude=getIntent().getDoubleExtra(IntentParams.KEY_LATITUDE,0);
        longitude=getIntent().getDoubleExtra(IntentParams.KEY_LONGITUDE,0);
        LinearLayout titleLayout=findViewById(R.id.title_parent_top);
        mapView = (MapView)findViewById(R.id.bmap_View);
        titleLayout.setBackgroundColor(getResources().getColor(R.color.transparent));
        /*if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            FrameLayout.LayoutParams params= (FrameLayout.LayoutParams) titleLayout.getLayoutParams();
            params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            titleLayout.setLayoutParams(params);


            RelativeLayout.LayoutParams mapParams= (RelativeLayout.LayoutParams) mapView.getLayoutParams();
            mapParams.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            mapView.setLayoutParams(mapParams);

        }*/
        initMark();

        leftBack=findViewById(R.id.header_left_btn_img);
        leftBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getActivity().finish();

            }
        });

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
        LatLng locationLatLng=new LatLng(latitude,longitude);
        setMarkerOptions(locationLatLng);
        startLocation();
    }


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
                    //errCode等于0代表定位成功，其他的为定位失败，具体的可以参照官网定位错误码说明
                    if(location.getErrorCode() == 0){
                        locationClient.stopLocation();
                        LatLng locationLatLng=new LatLng(location.getLatitude(),location.getLongitude());
                        if(locationLatLng!=null){
                            MarkerOptions markerOptions = new MarkerOptions();
                            markerOptions.draggable(true);//设置Marker可拖动
                            markerOptions.position(locationLatLng);
                            markerOptions.period(50);
                            markerOptions.setFlat(true);//设置marker平贴地图效果
                            markerOptions.draggable(true);
                            aMap.addMarker(markerOptions);
                            /*aMap.moveCamera(CameraUpdateFactory.changeLatLng(locationLatLng));
                            aMap.moveCamera(CameraUpdateFactory.zoomTo(10));*/
                        }
                    } else {
                        //定位失败

                    }

                } else {
                    //tvResult.setText("定位失败，loc is null");
                    /*getActivity().runOnUiThread(new Runnable() {
                        @Override
                        public void run() {

                        }
                    });*/
                }

            } else {
                Toast.makeText(getActivity(), "定位失败，请检查您的网络.", Toast.LENGTH_LONG).show();
            }
        }
    }

    //设置我的位置
    private void setMarkerOptions(LatLng latLng) {
//        aMap.clear();
        MarkerOptions markerOptions = new MarkerOptions();
        markerOptions.draggable(true);//设置Marker可拖动
        markerOptions.position(latLng);
        markerOptions.period(50);
        //markerOptions.title("");
        markerOptions.icon(
                BitmapDescriptorFactory.fromBitmap(BitmapFactory
                        .decodeResource(getResources(),
                                R.drawable.icon_mark_show)));
        markerOptions.setFlat(true);//设置marker平贴地图效果
        markerOptions.draggable(true);
        aMap.addMarker(markerOptions);
        aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
        aMap.moveCamera(CameraUpdateFactory.zoomTo(12));


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
        /*
        今晚注释的
        if (isSertch) {
            // 如果需要搜索
            latLonPoint = new LatLonPoint(cameraPosition.target.latitude, cameraPosition.target.longitude);
            currentPage = 1;
            initSearch();
        }*/

    }
}
