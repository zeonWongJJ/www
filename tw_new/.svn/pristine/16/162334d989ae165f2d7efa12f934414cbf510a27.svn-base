package app.vdaoadmin.qidu;

import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.support.annotation.NonNull;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;

import app.vdaoadmin.qidu.bean.TabEntity;
import app.vdaoadmin.qidu.fragment.HomeFragment;
import app.vdaoadmin.qidu.fragment.ManageUserFragment;
import app.vdaoadmin.qidu.fragment.OrderListFragment;
import app.vdaoadmin.qidu.fragment.SettingFragment;
import app.vdaoadmin.qidu.fragment.StoreListFragment;
import app.vdaoadmin.qidu.mvp.contract.LoginContract;
import app.vdaoadmin.qidu.mvp.presenter.LoginPresenterImpl;

import com.common.lib.global.AppUtils;
import com.common.lib.utils.ScreenUtils;
import com.flyco.tablayout.CommonTabLayout;
import com.flyco.tablayout.listener.CustomTabEntity;
import com.flyco.tablayout.listener.OnTabSelectListener;
import com.mvp.lib.base.BaseActivity;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseActivityView;

import java.util.ArrayList;


public class MainActivity extends BaseActivity<BasePresenter> implements IBaseActivityView {
    private ArrayList<Fragment> mFragments = new ArrayList<>();
    private ArrayList<CustomTabEntity> mTabEntities = new ArrayList<>();
    private CommonTabLayout mTabLayout_2;
    private String[] mTitles = {"首页", "用户", "门店","设置"};
    private int[] mIconUnselectIds = {
            R.drawable.tab_home_unselect,R.drawable.tab_user_unselect, R.drawable.tab_store_unselect,R.drawable.tab_setting_unselect};
    private int[] mIconSelectIds = {
            R.drawable.tab_home_select, R.drawable.tab_user_select,R.drawable.tab_store_select,R.drawable.tab_setting_select};
    private ViewPager mViewPager;

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        ImageView status_view= (ImageView) findViewById(R.id.status_view);
        View status_view_layout=findViewById(R.id.status_bar_layout);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
            LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) status_view.getLayoutParams();
            params.height=ScreenUtils.getStatusBarHeight(this);
            //params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            status_view.setLayoutParams(params);
            status_view_layout.setVisibility(View.VISIBLE);
        }
        mFragments.add(HomeFragment.getInstance("Switch ViewPager " + mTitles[0]));
        mFragments.add(ManageUserFragment.getInstance("Switch ViewPager " + mTitles[1]));
        mFragments.add(StoreListFragment.getInstance("Switch ViewPager " + mTitles[2]));
        //mFragments.add(OrderListFragment.getInstance("Switch ViewPager " + mTitles[3]));
        mFragments.add(SettingFragment.getInstance("Switch ViewPager " + mTitles[3]));

        for (int i = 0; i < mTitles.length; i++) {
            mTabEntities.add(new TabEntity(mTitles[i], mIconSelectIds[i], mIconUnselectIds[i]));
        }
        mViewPager = findView(R.id.vp_2);
        mViewPager.setAdapter(new MyPagerAdapter(getSupportFragmentManager()));
        /** with ViewPager */
        mTabLayout_2 = findView( R.id.tl_2);
        mTabLayout_2.setTabData(mTabEntities);
        //Random mRandom = new Random();
        mTabLayout_2.setOnTabSelectListener(new OnTabSelectListener() {
            @Override
            public void onTabSelect(int position) {
                mViewPager.setCurrentItem(position);
            }

            @Override
            public void onTabReselect(int position) {
                /*if (position == 0) {
                    mTabLayout_2.showMsg(0, mRandom.nextInt(100) + 1);
//                    UnreadMsgUtils.show(mTabLayout_2.getMsgView(0), mRandom.nextInt(100) + 1);
                }*/
            }
        });

        mViewPager.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
                mTabLayout_2.setCurrentTab(position);
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });

        mViewPager.setCurrentItem(0);


        //两位数
        /*mTabLayout_2.showMsg(0, 55);
        mTabLayout_2.setMsgMargin(0, -5, 5);

        //三位数
        mTabLayout_2.showMsg(1, 100);
        mTabLayout_2.setMsgMargin(1, -5, 5);

        //设置未读消息红点
        mTabLayout_2.showDot(2);
        MsgView rtv_2_2 = mTabLayout_2.getMsgView(2);
        if (rtv_2_2 != null) {
            UnreadMsgUtils.setSize(rtv_2_2, ScreenUtils.dp2px(getActivity(),7.5f));
        }

        //设置未读消息背景
        mTabLayout_2.showMsg(3, 5);
        mTabLayout_2.setMsgMargin(3, 0, 5);
        MsgView rtv_2_3 = mTabLayout_2.getMsgView(3);
        if (rtv_2_3 != null) {
            rtv_2_3.setBackgroundColor(Color.parseColor("#6D8FB0"));
        }*/

    }

    public void fragmentTabChange(int position){
        mViewPager.setCurrentItem(position);
    }
    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View inflate = inflater.inflate(R.layout.activity_main, null);
        return inflate;
    }

    @Override
    protected BasePresenter initPresenter() {
        return new BasePresenter() {
            @Override
            public void onCreate() {

            }

            @Override
            public void loadData() {

            }
        };
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
