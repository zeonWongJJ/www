package app.vdaoadmin.qidu.activity;

import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ScreenUtils;
import com.flyco.tablayout.SlidingTabLayout;
import com.flyco.tablayout.listener.OnTabSelectListener;
import com.mvp.lib.base.BaseActivity;

import java.util.ArrayList;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.fragment.LunchOrderFragment;
import app.vdaoadmin.qidu.mvp.contract.OrderTabContract;
import app.vdaoadmin.qidu.mvp.presenter.OrderTabPresenterImpl;

/**
 * 餐饮订单-会议订单-座位订单
 */

public class LunchOrderActivity extends AbsBaseActivity implements  OnTabSelectListener {
    public static int LUNCH_ORDER_TYPE=1;//餐饮订单
    public static int MEETING_ORDER_TYPE=2;//会议订单
    public static int SEAT_ORDER_TYPE=3;//座位订单
    private ArrayList<Fragment> mFragments = new ArrayList<>();
    private String[] mTitles =null;
    private ViewPager vp;
    private int orderType=0;
    private MyPagerAdapter mAdapter;

    protected void initViewsAndEvents(Bundle savedInstanceState) {
        ImageView status_view= (ImageView) findViewById(R.id.status_view);
        View status_view_layout=findViewById(R.id.status_bar_layout);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
            LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) status_view.getLayoutParams();
            params.height= ScreenUtils.getStatusBarHeight(this);
            //params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            status_view.setLayoutParams(params);
            status_view_layout.setVisibility(View.VISIBLE);
        }
        TextView titleCenter=findViewById(R.id.header_text);
        View back=findViewById(R.id.header_left_btn_img);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        orderType=getIntent().getIntExtra(IntentParams.KEY_ORDER_TYPE,0);
        String store_img_url=getIntent().getStringExtra(IntentParams.KEY_STORE_IMG_URL);
        String storeId=getIntent().getStringExtra(IntentParams.KEY_STORE_ID);
        String storeName=getIntent().getStringExtra(IntentParams.KEY_STORE_NAME);
        if(orderType==1){//
            titleCenter.setText("餐饮订单");
            mTitles = new String[]{"全部", "待付款", "待接单", "待配送", "配送中","已收货","已完成","已取消"};
        }else if(orderType==2){
            titleCenter.setText("会议订单");
            mTitles = new String[]{"全部", "待接单", "待服务", "服务中","待评价", "已完成","已取消"};
        }else if(orderType==3){
            titleCenter.setText("座位订单");
            mTitles = new String[]{"全部", "待接单", "待入座", "入座中","待评价", "已完成","已取消"};
        }
        for (String title : mTitles) {
            mFragments.add(LunchOrderFragment.getInstance(storeName,storeId,orderType,title,store_img_url));
        }
        vp=findViewById(R.id.vp);
        mAdapter = new MyPagerAdapter(getSupportFragmentManager());
        vp.setAdapter(mAdapter);
        SlidingTabLayout tabLayout = findViewById(R.id.sliding_tab_layout);
        tabLayout.setViewPager(vp, mTitles);
        vp.setCurrentItem(0);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lunch_order);
        initViewsAndEvents(savedInstanceState);
    }


    @Override
    public void onTabSelect(int position) {
        Toast.makeText(getApplicationContext(), "onTabSelect&position--->" + position, Toast.LENGTH_SHORT).show();
    }

    @Override
    public void onTabReselect(int position) {
        Toast.makeText(getApplicationContext(), "onTabReselect&position--->" + position, Toast.LENGTH_SHORT).show();
    }

    private class MyPagerAdapter extends FragmentPagerAdapter {
        public MyPagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public int getCount() {
            return mFragments.size();
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return mTitles[position];
        }

        @Override
        public Fragment getItem(int position) {
            return mFragments.get(position);
        }
    }
}
