package app.odp.qidu.fragment;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import com.common.lib.base.BaseLazyFragment;
import com.common.lib.utils.StatusBarUtil;
import com.flyco.tablayout.CommonTabLayout;
import com.flyco.tablayout.SlidingTabLayout;
import com.flyco.tablayout.listener.CustomTabEntity;
import com.flyco.tablayout.listener.OnTabSelectListener;
import com.luck.picture.lib.immersive.LightStatusBarUtils;

import java.util.ArrayList;

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishPlanActivity;
import app.odp.qidu.adapter.MyPagerAdapter;
import app.odp.qidu.bean.TabEntity;

/**
 *计划
 */

public class TabPlanFragment extends BaseLazyFragment implements OnTabSelectListener {
    private ArrayList<CustomTabEntity> mTabEntities = new ArrayList<>();
    private ArrayList<PlanChildFragment> mFragments = new ArrayList<>();
    private String[] mTitles =null;
    private ViewPager vp;
    private MyPagerAdapter mAdapter;

    private String param;
    public static TabPlanFragment getInstance(String param) {
        TabPlanFragment sf = new TabPlanFragment();
        sf.param = param;
        return sf;
    }
    @Override
    protected void onVisible() {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.title_bg);
        LightStatusBarUtils.setLightStatusBar(getActivity(),false);
    }
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_top_tab,null);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        TextView titleCenter=view.findViewById(R.id.title_center_text);
        titleCenter.setText("计划");
        View back=view.findViewById(R.id.title_left_image);
        back.setVisibility(View.GONE);
        TextView right=view.findViewById(R.id.title_right_text);
        right.setBackground(getResources().getDrawable(R.drawable.shape_white_stroke_corner));
        right.setText("发布计划");
        right.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(),PublishPlanActivity.class);
            getActivity().startActivity(intent);
        });
        mTitles = new String[]{"我的计划", "参与计划", "他人计划"};
        String[] actions=new String[]{PlanChildFragment.MY_PLAN,PlanChildFragment.JOIN_PLAN,PlanChildFragment.OTHER_PLAN};
        for (int i=0;i<actions.length;i++) {
            mFragments.add(PlanChildFragment.getInstance(actions[i],mTitles[i]));
        }

        vp=view.findViewById(R.id.viewpager);
        mAdapter = new MyPagerAdapter(getChildFragmentManager(),mFragments);
        vp.setAdapter(mAdapter);
        CommonTabLayout tabLayout = view.findViewById(R.id.tab_layout);
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

}
