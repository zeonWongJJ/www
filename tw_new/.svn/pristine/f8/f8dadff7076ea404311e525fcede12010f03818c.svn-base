package com.qidu.chat.fragment.chatroom.dialog;

import android.app.ProgressDialog;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.os.Environment;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.app.AppCompatDialogFragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AbsListView;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.amap.api.location.AMapLocation;
import com.amap.api.location.AMapLocationClient;
import com.amap.api.location.AMapLocationClientOption;
import com.amap.api.location.AMapLocationListener;
import com.amap.api.maps.AMap;
import com.amap.api.maps.CameraUpdateFactory;
import com.amap.api.maps.LocationSource;
import com.amap.api.maps.MapView;
import com.amap.api.maps.model.CameraPosition;
import com.amap.api.maps.model.LatLng;
import com.amap.api.maps.model.MarkerOptions;
import com.amap.api.services.core.LatLonPoint;
import com.amap.api.services.core.PoiItem;
import com.amap.api.services.poisearch.PoiResult;
import com.amap.api.services.poisearch.PoiSearch;
import com.qidu.chat.adapter.LocationListAdapter;


import com.qidu.chat.R;
import com.qidu.chat.widget.LoadMoreView;

import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.Serializable;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;


/**
 * 发送定位
 */

public class SendLocationDialogFragment extends AppCompatDialogFragment implements LocationSource, AMapLocationListener, AMap.OnCameraChangeListener, PoiSearch.OnPoiSearchListener {
    private MapView mapView;
    private AMap aMap;//地图对象
    private LocationSource.OnLocationChangedListener mListener;//位置移动监听
    private AMapLocationClient mlocationClient;
    //声明AMapLocationClientOption对象
    private AMapLocationClientOption mLocationOption;
    private LatLng latLng;
    private int currentPage=1;//当前页数    0和的数据一样，从一开始
    private int pageSize=10;
    private LocationListAdapter adapter; //周边的适配器
    private LatLonPoint latLonPoint;
    private List<PoiItem> poiItemList;

    private boolean isSertch = true;           //判断是否需要更新数据



    private String params;
    private View rootView;
    public static SendLocationDialogFragment create(
            String params) {
        SendLocationDialogFragment fragment = new SendLocationDialogFragment();
        fragment.setParams(params);

        return fragment;
    }
    public void setParams(String params) {
        this.params = params;
    }


    private ImageView original;
    private LocationListAdapter adatper;

    private ListView listView;


    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setStyle(AppCompatDialogFragment.STYLE_NORMAL, android.R.style.Theme_Black_NoTitleBar);

    }

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        rootView=inflater.inflate(R.layout.fragment_send_location_dialog,container,false);
        return rootView;
    }


    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        setTitle();
        mLoadMoreView=new LoadMoreView(getActivity());
        original = (ImageView) rootView.findViewById(R.id.bmap_local_myself);
        listView = (ListView) rootView.findViewById(R.id.bmap_listview);
        ImageView centerIcon = (ImageView) rootView.findViewById(R.id.bmap_center_icon);
        mapView = (MapView) rootView.findViewById(R.id.bmap_View);
        mapView.onCreate(savedInstanceState);
        adapter = new LocationListAdapter(listView,
                poiItemList);
        listView.setAdapter(adapter);
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                PoiItem itemData = (PoiItem)adapter.getItem(position);
                //miaoshu.setText(itemData.getTitle());
                LatLonPoint latLonPoint = (itemData.getLatLonPoint());
                latLng = new LatLng(latLonPoint.getLatitude(), latLonPoint.getLongitude());
//                    setMarkenOntions(latLng);
                isSertch = false;
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                adapter.setSelection(position);

            }
        });
        listView.setOnScrollListener(new AbsListView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(AbsListView absListView, int i) {

            }
            @Override
            public void onScroll(AbsListView absListView,  int firstVisibleItem, int visibleItemCount, int totalItemCount) {
                int lastVisibleItem = firstVisibleItem + visibleItemCount;
                //Log.e(TAG, "onScroll: "+ lastVisibleItem+"总个数为:"+totalItemCount);
                if (!mIsLoading && !mIsPageFinished && lastVisibleItem == totalItemCount) {
                    mIsLoading = true;
                    // 显示加载更多布局
                    listView.addFooterView(mLoadMoreView);
                    initSearch();
                }
            }
        });
        if (aMap == null) {
            aMap = mapView.getMap();
            setUpMap();
        }
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
                isSertch = true;
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


    private void showRightWithText(String str,
                                   View.OnClickListener clickListener) {
        TextView rightText = (TextView) rootView.findViewById(R.id.right_title_text);
        rightText.setVisibility(View.VISIBLE);
        rightText.setText(str);

        //设置点击区域
        LinearLayout rightClickRange = (LinearLayout) rootView.findViewById(R.id.right_title_layout);
        rightClickRange.setOnClickListener(clickListener);
    }

    protected void showLeftWithImage(int resId,
                                     View.OnClickListener clickListener) {
        ImageView leftImage = (ImageView) rootView.findViewById(R.id.left_title_image);
        leftImage.setVisibility(View.VISIBLE);
        leftImage.setImageResource(resId);

        //设置点击区域
        LinearLayout leftClickRange = (LinearLayout) rootView.findViewById(R.id.left_title_layout);
        leftClickRange.setOnClickListener(clickListener);
    }

    private void setTitle() {
        TextView title = (TextView) rootView.findViewById(R.id.center_title);
        title.setText("位置信息");
        showRightWithText("发送", new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                aMap.getMapScreenShot(new AMap.OnMapScreenShotListener() {
                    @Override
                    public void onMapScreenShot(Bitmap bitmap) {

                    }

                    @Override
                    public void onMapScreenShot(Bitmap bitmap, int i) {
                        SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMddHHmmss");
                        if (null == bitmap) {
                            return;
                        }
                        try {
                            String path = Environment.getExternalStorageDirectory() + "/test_"
                                    + sdf.format(new Date()) + ".png";
                            FileOutputStream fos = new FileOutputStream(path);
                            bitmap.compress(Bitmap.CompressFormat.PNG, 100, fos);
                            try {
                                fos.flush();
                            } catch (IOException e) {
                                e.printStackTrace();
                            }
                            try {
                                fos.close();
                            } catch (IOException e) {
                                e.printStackTrace();
                            }
                            PoiItem selected = adapter.getItem(adapter.getSelection());

                            Log.i("bbbbb",path+"保存路径"+selected.getTitle()+"-----"+selected.getLatLonPoint().getLatitude());
                            /*Intent intent = getActivity().getIntent();
                            intent.putExtra("selected", (Serializable) selectedMap);
                            getActivity().setResult(RESULT_OK, intent);
                            getActivity().finish();*/
                            String str="地图截图本地路径"+path+"地址:"+selected.getSnippet()+"纬度:"+selected.getLatLonPoint().getLatitude()+"经度:"+selected.getLatLonPoint().getLongitude();
                            callbackOnLocation(str);
                            dismiss();
                        } catch (FileNotFoundException e) {
                            e.printStackTrace();
                        }
                    }
                });
                //callbackOnLocation(lastInfo.address);
                //dismiss();
            }
        });
        showLeftWithImage(R.drawable.btn_back, new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dismiss();
            }
        });
    }





    private void callbackOnLocation(String message) {
        final Fragment fragment = getTargetFragment();
        if (fragment instanceof SendLocationCallback) {
            ((SendLocationDialogFragment.SendLocationCallback) fragment).onSuccessLocationCallBack(message);
        }
    }

    public interface SendLocationCallback {
        void onSuccessLocationCallBack(String message);
    }



    //-------------------------------
    //激活定位  LocationSource
    @Override
    public void activate(OnLocationChangedListener onLocationChangedListener) {
        mListener = onLocationChangedListener;
        if (mlocationClient == null) {
            mlocationClient = new AMapLocationClient(getActivity());
            mLocationOption = new AMapLocationClientOption();
            mLocationOption.setLocationMode(AMapLocationClientOption.AMapLocationMode.Hight_Accuracy);
            //设置定位监听
            mlocationClient.setLocationListener(this);
            //间隔多少秒
//            mLocationOption.setInterval(500000);
            //设置为高精度定位模式
            mLocationOption.setLocationMode(AMapLocationClientOption.AMapLocationMode.Hight_Accuracy);
            //获取一次定位结果：
//        //该方法默认为false。
            mLocationOption.setOnceLocation(true);
            //设置定位参数
            mlocationClient.setLocationOption(mLocationOption);
            // 此方法为每隔固定时间会发起一次定位请求，为了减少电量消耗或网络流量消耗，
            // 注意设置合适的定位时间的间隔（最小间隔支持为2000ms），并且在合适时间调用stopLocation()方法来取消定位请求
            // 在定位结束后，在合适的生命周期调用onDestroy()方法
            // 在单次定位情况下，定位无论成功与否，都无需调用stopLocation()方法移除请求，定位sdk内部会移除

            mlocationClient.startLocation();

        }

    }

    //停止定位  LocationSource
    @Override
    public void deactivate() {
        mListener = null;
        if (mlocationClient != null) {
            mlocationClient.stopLocation();
            mlocationClient.onDestroy();
        }
        mlocationClient = null;
    }

    /**
     * 当有数据返回的时候  setLocationListener
     *
     * @param aMapLocation
     */
    @Override
    public void onLocationChanged(AMapLocation aMapLocation) {
        if (mListener != null && aMapLocation != null) {
            if (aMapLocation != null
                    && aMapLocation.getErrorCode() == 0) {
                //网络请求到的坐标系
                latLng = new LatLng(aMapLocation.getLatitude(), aMapLocation.getLongitude());
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                setMarkenOntions(latLng);
                //search(latLng,15);              //当定位完成,获取后进行搜索

                /*//搜索poi
                    searchPoi("", 0, currentInfo.get("cityCode"), true);
                    //latitude=41.652146#longitude=123.427205#province=辽宁省#city=沈阳市#district=浑南区#cityCode=024#adCode=210112#address=辽宁省沈阳市浑南区创新一路靠近东北大学浑南校区#country=中国#road=创新一路#poiName=东北大学浑南校区#street=创新一路#streetNum=193号#aoiName=东北大学浑南校区#poiid=#floor=#errorCode=0#errorInfo=success#locationDetail=24 #csid:1cce9508143d493182a8da7745eb07b3#locationType=5
*/
            } else {
                String errText = "定位失败," + aMapLocation.getErrorCode() + ": " + aMapLocation.getErrorInfo();
                Toast.makeText(getActivity(), "定位失败，请检查您的网络.", Toast.LENGTH_LONG).show();
                Log.e("AmapErr", errText);

            }
        }
    }

    //设置我的位置
    private void setMarkenOntions(LatLng latLng) {
//        aMap.clear();
        MarkerOptions markerOptions = new MarkerOptions();
        markerOptions.draggable(false);//设置Marker可拖动
        markerOptions.position(latLng);
        markerOptions.period(50);
        markerOptions.setFlat(true);//设置marker平贴地图效果
        aMap.addMarker(markerOptions);
        aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
        aMap.moveCamera(CameraUpdateFactory.zoomTo(15));


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
    public void onDestroy() {
        super.onDestroy();
        mapView.onDestroy();
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
     *
     * @param cameraPosition
     */
    @Override
    public void onCameraChangeFinish(CameraPosition cameraPosition) {
        if (isSertch) {
            // 如果需要搜索
            latLonPoint = new LatLonPoint(cameraPosition.target.latitude, cameraPosition.target.longitude);
            currentPage = 1;
            initSearch();
        }

    }

    /**
     * 搜索周边的逻辑
     */
    private void initSearch() {
        PoiSearch.Query query = new PoiSearch.Query("", "餐饮服务|商务住宅|生活服务", "");// 第一个参数表示搜索字符串，第二个参数表示poi搜索类型，第三个参数表示poi搜索区域（空字符串代表全国）
        query.setPageSize(pageSize);// 设置每页最多返回多少条poiitem
        query.setPageNum(currentPage);// 设置查第一页
        PoiSearch poiSearch = new PoiSearch(getActivity(), query);
        poiSearch.setOnPoiSearchListener(this);
        poiSearch.setBound(new PoiSearch.SearchBound(latLonPoint, 500, true));//
        poiSearch.searchPOIAsyn();// 异步搜索
    }

    /**
     * 当搜索有结果的时候的回调
     *
     * @param poiResult
     * @param rCode
     */
    @Override
    public void onPoiSearched(PoiResult poiResult, int rCode) {
        if (rCode == 1000) {
            if(!poiResult.getPois().isEmpty()){
                List<PoiItem> list=poiResult.getPois();
                if(currentPage==1){
                    adapter.refresh(list);
                }else {
                    adapter.append(list);
                }
                if(list.size()==pageSize){
                    currentPage++;
                    onFinishLoading(false);
                }else {
                    onFinishLoading(true);
                }
                //setData(poiItems.size() >= 10 ? -1 : 0);
            }else {
                noMoreData();
            }
        }
    }

    @Override
    public void onPoiItemSearched(PoiItem poiItem, int i) {
    }



    public void onFinishLoading(boolean isPageFinished) {
        mIsLoading = false;
        setIsPageFinished(isPageFinished);

    }

    private void setIsPageFinished(boolean isPageFinished) {
        mIsPageFinished = isPageFinished;
        listView.removeFooterView(mLoadMoreView);
    }
    public void noMoreData(){
        mIsLoading = true;
        setIsPageFinished(true);
    }
    private boolean mIsLoading = false;
    private boolean mIsPageFinished = false;
    private View mLoadMoreView;
}
