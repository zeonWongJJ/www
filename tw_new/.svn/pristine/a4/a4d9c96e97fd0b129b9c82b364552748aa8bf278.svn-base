package app.vdao.qidu.activity;

import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.amap.api.services.district.DistrictItem;
import com.amap.api.services.district.DistrictResult;
import com.amap.api.services.district.DistrictSearch;
import com.amap.api.services.district.DistrictSearchQuery;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.gzqx.com.gzqx.org.common.R;
import com.gzqx.common.datautil.SharedPreferencesUtils;
import com.gzqx.common.pingyin.CharacterParser;
import com.gzqx.common.pingyin.SideBar;
import com.gzqx.common.utils.CommonKey;

import app.vdao.qidu.adapter.SortAdapter;
import app.vdao.qidu.bean.SortModel;
import app.vdao.qidu.common.PinyinComparator;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

public abstract class CitySearchListActivity extends BaseMarkActivity implements DistrictSearch.OnDistrictSearchListener {

    private ListView sortListView;
    private SideBar sideBar;
    private TextView dialog;
    private SortAdapter adapter;
    /**
     * 汉字转换成拼音的类
     */
    private CharacterParser characterParser;
    private List<SortModel> SourceDateList;
    /**
     * 根据拼音来排列ListView里面的数据类
     */
    private PinyinComparator pinyinComparator;

    private List<DistrictItem> districtList=new ArrayList<>();
    private boolean isFirst=false;
    protected TextView currentLocationCity;

    private boolean isLoadAllCity;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {

        currentLocationCity=findViewById(R.id.current_location_city);
        characterParser = CharacterParser.getInstance();
        pinyinComparator = new PinyinComparator();

        sideBar = (SideBar) findViewById(R.id.sidrbar);
        dialog = (TextView) findViewById(R.id.dialog);
        sideBar.setTextView(dialog);
        // 设置右侧触摸监听
        sortListView = (ListView) findViewById(R.id.country_lvcountry);

        String cacheCityResponse=(String)SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_ALL_CHINA_CITY_NAME,"");
        isLoadAllCity=(boolean)SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_LOAD_ALL_CHINA_CITY_FINISH,false);
        if(!TextUtils.isEmpty(cacheCityResponse)){
            Gson gson=new Gson();
            districtList= gson.fromJson(cacheCityResponse, new TypeToken<List<DistrictItem>>() {}.getType());
            initSortData();
            long defaultTime=0;
            long saveTime=(long)SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_ALL_CITY_REFRESH_TIME,defaultTime);
            long currentTime = System.currentTimeMillis();
            long s = (currentTime - saveTime) / (1000*60*60*24);
            //Log.i("bbbbbbbb",""+s);
            if(s>7){//间隔大于七天更新一次
                initSearch("中国");
            }
        }else {
            initSearch("中国");
        }

    }

    protected abstract void onCityChangeSelect(SortModel item);

    private void initSearch(String keyword){
        DistrictSearch search = new DistrictSearch(mContext);
        DistrictSearchQuery query = new DistrictSearchQuery();
        query.setKeywords(keyword);//传入关键字
        query.setShowChild(true);
        query.setShowBoundary(true);//是否返回边界值
        search.setQuery(query);
        search.setOnDistrictSearchListener(this);//绑定监听器
        search.searchDistrictAnsy();//开始搜索
        //search.searchDistrictAsyn();
    }

    private List<DistrictItem> wholeProvince;
    @Override
    public void onDistrictSearched(DistrictResult districtResult) {
        if(districtResult.getAMapException().getErrorCode()==1000){
            if(!isFirst) {
                isFirst=true;
                wholeProvince = districtResult.getDistrict().get(0).getSubDistrict();
                for (int i = 0; i < wholeProvince.size();i++) {
                    DistrictItem item = wholeProvince.get(i);
                    if (!TextUtils.isEmpty(item.getCitycode())) {
                        districtList.add(item);
                        wholeProvince.remove(item);
                    } /*else {
                        final String keyword = item.getName();
                        initSearch(keyword);
                    }*/
                }
                if(!isLoadAllCity){
                    initSortData();
                }
                if(wholeProvince!=null){
                    if(wholeProvince.size()>0){
                        final String keyword = wholeProvince.get(0).getName();
                        initSearch(keyword);
                    }
                }
                //initSortData();
            }else {

                DistrictItem districtItem=districtResult.getDistrict().get(0);
                for(int i=0;i<wholeProvince.size();i++){
                    DistrictItem province=wholeProvince.get(i);
                    if(province.getName().equals(districtItem.getName())){
                        wholeProvince.remove(province);
                    }
                }
                List<DistrictItem> cityList = districtResult.getDistrict().get(0).getSubDistrict();
                districtList.addAll(cityList);
                //每获得一个省的城市刷新一次列表  避免单次获取失败或者等待没数据显示
                if(!isLoadAllCity){
                    initSortData();
                }

                if(wholeProvince!=null){
                    if(wholeProvince.size()>0){
                        final String keyword = wholeProvince.get(0).getName();
                        initSearch(keyword);
                    }else {
                        Gson gson=new Gson();
                        String response=gson.toJson(districtList);
                        //获取到所有城市的时候
                        SharedPreferencesUtils.getInstance().saveData(CommonKey.KEY_ALL_CHINA_CITY_NAME,response);
                        SharedPreferencesUtils.getInstance().saveData(CommonKey.KEY_LOAD_ALL_CHINA_CITY_FINISH,true);
                        long currentTime = System.currentTimeMillis();
                        SharedPreferencesUtils.getInstance().saveData(CommonKey.KEY_ALL_CITY_REFRESH_TIME,currentTime);

                    }
                }
            }
        }else {
            Toast.makeText(getActivity(),"获取城市失败",Toast.LENGTH_SHORT).show();
        }
    }

    private void initSortData(){
        SourceDateList = filledData(districtList);
        // 根据a-z进行排序源数据
        Collections.sort(SourceDateList, pinyinComparator);
        adapter = new SortAdapter(this, SourceDateList);
        sortListView.setAdapter(adapter);
        sideBar.setOnTouchingLetterChangedListener(new SideBar.OnTouchingLetterChangedListener() {
            @Override
            public void onTouchingLetterChanged(String s) {
                // 该字母首次出现的位置
                int position = adapter.getPositionForSection(s.charAt(0));
                if (position != -1) {
                    sortListView.setSelection(position);
                }
            }
        });
        sortListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                // 这里要利用adapter.getItem(position)来获取当前position所对应的对象
                SortModel item= adapter.getItem(position);
                if(item==null){
                    return;
                }
                //Toast.makeText(getActivity(),""+item.getName(),Toast.LENGTH_SHORT).show();
                onCityChangeSelect(item);
                //currentCity.setText(item.getName());
            }
        });
    }

    /*@Override
    protected int getContentViewID() {
        return R.layout.activity_city_search_list;
    }*/


    /**
     * 为ListView填充数据
     *
     * @param list
     * @return
     */
    private List<SortModel> filledData(List<DistrictItem> list) {
        List<SortModel> mSortList = new ArrayList<SortModel>();

        for (int i = 0; i < list.size(); i++) {
            SortModel sortModel = new SortModel();
            sortModel.setName(list.get(i).getName());
            sortModel.setCityCode(list.get(i).getCitycode());
            sortModel.setLatLonPoint(list.get(i).getCenter());
            // 汉字转换成拼音
            String pinyin = characterParser.getSelling(list.get(i).getName());
            String sortString = pinyin.substring(0, 1).toUpperCase();

            // 正则表达式，判断首字母是否是英文字母
            if (sortString.matches("[A-Z]")) {
                sortModel.setSortLetters(sortString.toUpperCase());
            } else {
                sortModel.setSortLetters("#");
            }

            mSortList.add(sortModel);
        }
        return mSortList;

    }

    /**
     * 根据输入框中的值来过滤数据并更新ListView
     *
     * @param filterStr
     */
    private void filterData(String filterStr) {
        List<SortModel> filterDateList = new ArrayList<SortModel>();
        if (TextUtils.isEmpty(filterStr)) {
            filterDateList = SourceDateList;
        } else {
            filterDateList.clear();
            for (SortModel sortModel : SourceDateList) {
                String name = sortModel.getName();
                if (name.indexOf(filterStr.toString()) != -1
                        || characterParser.getSelling(name).startsWith(
                        filterStr.toString())) {
                    filterDateList.add(sortModel);
                }
            }
        }

        // 根据a-z进行排序
        Collections.sort(filterDateList, pinyinComparator);
        adapter.updateListView(filterDateList);
    }



    @Override
    protected void onDestroy() {
        super.onDestroy();
        //destroyLocation();
    }

}
