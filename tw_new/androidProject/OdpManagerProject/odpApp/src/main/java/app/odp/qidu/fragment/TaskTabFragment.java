package app.odp.qidu.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.common.lib.base.AbsBaseFragment;
import com.flyco.tablayout.CommonTabLayout;
import com.flyco.tablayout.SlidingTabLayout;
import com.flyco.tablayout.listener.CustomTabEntity;
import com.flyco.tablayout.listener.OnTabSelectListener;

import java.util.ArrayList;

import app.odp.qidu.R;
import app.odp.qidu.bean.TabEntity;

/**
 * Created by 7du-28 on 2018/5/24.
 */

public class TaskTabFragment extends AbsBaseFragment implements OnTabSelectListener {
    private ArrayList<CustomTabEntity> mTabEntities = new ArrayList<>();
    private ArrayList<TaskHomeFragment> mFragments = new ArrayList<>();
    private String[] mTitles =null;
    private ViewPager vp;
    private MyPagerAdapter mAdapter;
    private String action;
    public static TaskTabFragment getInstance(String param) {
        TaskTabFragment sf = new TaskTabFragment();
        sf.action = param;
        return sf;
    }


    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_task_tab,container,false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        mTitles = new String[]{"未完成", "已完成"};
        mFragments.add(TaskHomeFragment.getInstance(action,TaskHomeFragment.NO_COMPLETE));
        mFragments.add(TaskHomeFragment.getInstance(action,TaskHomeFragment.COMPLETE));
        vp=view.findViewById(R.id.vp);
        mAdapter = new MyPagerAdapter(getChildFragmentManager());
        vp.setAdapter(mAdapter);
        CommonTabLayout tabLayout = view.findViewById(R.id.sliding_tab_layout);
        for (int i = 0; i < mTitles.length; i++) {
            mTabEntities.add(new TabEntity(mTitles[i], 0, 0));
        }
        tabLayout.setTabData(mTabEntities);
        tabLayout.setOnTabSelectListener(this);
        vp.setOffscreenPageLimit(mTitles.length);
        vp.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
                tabLayout.setCurrentTab(position);
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });
        vp.setCurrentItem(0);
    }

    @Override
    public void onTabSelect(int position) {
        vp.setCurrentItem(position);
    }

    @Override
    public void onTabReselect(int position) {

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
