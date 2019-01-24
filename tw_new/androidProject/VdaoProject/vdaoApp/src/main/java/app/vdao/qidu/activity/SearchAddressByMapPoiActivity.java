package app.vdao.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.AbsListView;
import android.widget.AdapterView;
import android.widget.ImageView;
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
import com.amap.api.services.core.AMapException;
import com.amap.api.services.core.LatLonPoint;
import com.amap.api.services.core.PoiItem;
import com.amap.api.services.poisearch.PoiResult;
import com.amap.api.services.poisearch.PoiSearch;
import com.gzqx.common.pingyin.ClearEditText;
import com.gzqx.common.utils.IntentParams;
import com.qidu.chat.adapter.LocationListAdapter;
import com.qidu.chat.widget.LoadMoreView;

import org.json.JSONException;
import org.json.JSONObject;
import app.vdao.qidu.R;
import app.vdao.qidu.bean.SortModel;

import java.util.List;


/**
 * 发送定位
 */

public class SearchAddressByMapPoiActivity extends CitySearchListActivity implements LocationSource, AMapLocationListener, AMap.OnCameraChangeListener, PoiSearch.OnPoiSearchListener {
    public static int resultCode=0x345;
    private MapView mapView;
    private AMap aMap;//地图对象
    private OnLocationChangedListener mListener;//位置移动监听
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

    private ClearEditText clearEditText;
    private ListView listView;
    private TextView headLocation;
    private ImageView centerIcon;
    private String cityCode="";
    private String keyword="";

    private View mapSearchLayout,citySearchLayout;

    private boolean showMap=false;
    private Handler handler;


    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        /*if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            LinearLayout titleLayout=findViewById(R.id.title_parent_top);
            FrameLayout.LayoutParams params= (FrameLayout.LayoutParams) titleLayout.getLayoutParams();
            params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            titleLayout.setLayoutParams(params);
        }*/
        initTitleView();
        super.initViewsAndEvents(savedInstanceState);
        initMark();
        handler=new Handler();
        mapSearchLayout=findViewById(R.id.map_search_layout);
        citySearchLayout=findViewById(R.id.city_search_layout);
        headTitle.setText("定位地址");
        clearEditText=findViewById(R.id.filter_edit);
        clearEditText.addTextChangedListener(new TextWatcher() {
            @Override
            public void onTextChanged(CharSequence s, int start, int before,
                                      int count) {
            }
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count,
                                          int after) {
            }

            @Override
            public void afterTextChanged(Editable s) {
                keyword=s.toString();
                currentPage=1;
                initSearch();
            }
        });
        /*clearEditText.setOnFocusChangeListener(new android.view.View.
                OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                if (hasFocus) {
                    // 此处为得到焦点时的处理内容
                    if(mapSearchLayout.getVisibility()==View.GONE) {
                        headLocation.setCompoundDrawablesWithIntrinsicBounds(0, 0, R.drawable.icon_arrow_down, 0);
                        mapSearchLayout.setVisibility(View.VISIBLE);
                        citySearchLayout.setVisibility(View.GONE);
                    }
                } else {
                    // 此处为失去焦点时的处理内容
                }
            }
        });*/
        headLocation=findViewById(R.id.head_location);
        headLocation.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                /*Intent intent=new Intent(getActivity(),CitySearchListActivity.class);
                startActivityForResult(intent,0x123);*/
                if(showMap){
                    showMap=false;
                    headLocation.setCompoundDrawablesWithIntrinsicBounds(0,0,R.drawable.icon_arrow_down,0);
                    mapSearchLayout.setVisibility(View.VISIBLE);
                    citySearchLayout.setVisibility(View.GONE);
                }else {
                    showMap=true;
                    headLocation.setCompoundDrawablesWithIntrinsicBounds(0,0,R.drawable.icon_arrow_up,0);
                    mapSearchLayout.setVisibility(View.GONE);
                    citySearchLayout.setVisibility(View.VISIBLE);
                }
            }
        });

        mLoadMoreView=new LoadMoreView(getActivity());
        listView = (ListView)findViewById(R.id.bmap_listview);
        centerIcon = (ImageView)findViewById(R.id.bmap_center_icon);
        mapView = (MapView)findViewById(R.id.bmap_View);
        mapView.onCreate(savedInstanceState);
        adapter = new LocationListAdapter(listView,
                poiItemList);
        listView.setAdapter(adapter);
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if(adapter.getCount()==0){
                    return;
                }
                PoiItem itemData = (PoiItem)adapter.getItem(position);
                //miaoshu.setText(itemData.getTitle());
                LatLonPoint latLonPoint = (itemData.getLatLonPoint());
                latLng = new LatLng(latLonPoint.getLatitude(), latLonPoint.getLongitude());
//                    setMarkenOntions(latLng);
                isSertch = false;
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                centerIcon.setVisibility(View.VISIBLE);
                adapter.setSelection(position);
                PoiItem selected = adapter.getItem(adapter.getSelection());
                            /*Intent intent = getActivity().getIntent();
                            intent.putExtra("selected", (Serializable) selectedMap);
                            getActivity().setResult(RESULT_OK, intent);
                            getActivity().finish();*/
                //final String str="地址:"+selected.getSnippet()+"纬度:"+selected.getLatLonPoint().getLatitude()+"经度:"+selected.getLatLonPoint().getLongitude();
                final String str=selected.getProvinceName()+selected.getCityName()+selected.getDirection()+selected.getSnippet()+selected.getTitle();
                //Toast.makeText(getActivity(),str,Toast.LENGTH_SHORT).show();
                final JSONObject jsonObject=new JSONObject();
                try {
                    jsonObject.put("provinceName",selected.getProvinceName());
                    jsonObject.put("cityName",selected.getCityName());
                    jsonObject.put("cityCode",selected.getCityCode());
                    jsonObject.put("adCode",selected.getAdCode());
                    jsonObject.put("direction",selected.getDirection());
                    jsonObject.put("snippet",selected.getSnippet());
                    jsonObject.put("title",selected.getTitle());
                    jsonObject.put("latitude",selected.getLatLonPoint().getLatitude());
                    jsonObject.put("longitude",selected.getLatLonPoint().getLongitude());
                    jsonObject.put("address",str);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        Intent intent=new Intent();
                        intent.putExtra(IntentParams.KEY_ADDRESS_INFO,jsonObject.toString());
                        setResult(resultCode,intent);
                        finish();
                    }
                },300);

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

    @Override
    protected int getContentViewID() {
        return R.layout.activity_mark_search_near_address;
    }//activity_search_address_map



    private void setUpMap() {
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
                isSertch = true;
                switch (motionEvent.getAction()) {
                    case MotionEvent.ACTION_DOWN://手放下

                        break;
                    case MotionEvent.ACTION_MOVE:  //手移动
                        centerIcon.setVisibility(View.INVISIBLE);
                        break;
                    case MotionEvent.ACTION_UP:
                        break;
                }
            }
        });

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

    @Override
    protected void onCityChangeSelect(SortModel item) {
        //centerIcon.setVisibility(View.VISIBLE);
        latLonPoint=item.getLatLonPoint();
        headLocation.setText(item.getName());
        mapSearchLayout.setVisibility(View.VISIBLE);
        citySearchLayout.setVisibility(View.GONE);
        cityCode=item.getCityCode();
        currentPage=1;
        keyword="";
        adapter.refresh(null);
        latLng = new LatLng(latLonPoint.getLatitude(), latLonPoint.getLongitude());
        setMarkenOntions(latLng);
        initSearch();
    }

    /**
     * 当有数据返回的时候  setLocationListener
     *
     * @param aMapLocation
     */
    @Override
    public void onLocationChanged(final AMapLocation aMapLocation) {
        if (mListener != null && aMapLocation != null) {
            if (aMapLocation != null
                    && aMapLocation.getErrorCode() == 0) {
                //网络请求到的坐标系
                latLng = new LatLng(aMapLocation.getLatitude(), aMapLocation.getLongitude());
                aMap.moveCamera(CameraUpdateFactory.changeLatLng(latLng));
                setMarkenOntions(latLng);
                currentLocationCity.setText(""+aMapLocation.getCity());
                currentLocationCity.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        SortModel model=new SortModel();
                        LatLonPoint latLonPoint=new LatLonPoint(aMapLocation.getLatitude(),aMapLocation.getLongitude());
                        model.setLatLonPoint(latLonPoint);
                        model.setCityCode(aMapLocation.getCityCode());
                        model.setName(aMapLocation.getCity());
                        onCityChangeSelect(model);
                    }
                });
                headLocation.setText(""+aMapLocation.getCity());
                cityCode=aMapLocation.getCityCode();
                currentPage=1;
                initSearch();

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
        //centerIcon.setVisibility(View.INVISIBLE);
    }

    /**
     * 当滑动地图结束后的操作
     *
     * @param cameraPosition
     */
    @Override
    public void onCameraChangeFinish(CameraPosition cameraPosition) {
        if (isSertch) {
            // 定位到当前所在城市 如果需要搜索
            latLonPoint = new LatLonPoint(cameraPosition.target.latitude, cameraPosition.target.longitude);
            currentPage = 1;
            initSearch();
        }

    }

    /**
     * 搜索周边的逻辑
     */
    private void initSearch() {//cityCode为城市区号
        if(cityCode==null){
            cityCode="";
        }
        PoiSearch.Query query = new PoiSearch.Query(keyword, "餐饮服务|商务住宅|生活服务", ""+cityCode);// 第一个参数表示搜索字符串，第二个参数表示poi搜索类型，第三个参数表示poi搜索区域（空字符串代表全国）
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

        if (rCode == AMapException.CODE_AMAP_SUCCESS) {
            /*List<SuggestionCity> suggestionCities = poiResult
                    .getSearchSuggestionCitys();// 当搜索不到poiitem数据时，会返回含有搜索关键字的城市信息
            Log.i("bbbbbb",suggestionCities.toString());*/
            List<PoiItem> list=poiResult.getPois();
            if(!list.isEmpty()){
                if(currentPage==1){
                    adapter.refresh(list);
                    adapter.setSelection(0);
                    centerIcon.setVisibility(View.VISIBLE);
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
