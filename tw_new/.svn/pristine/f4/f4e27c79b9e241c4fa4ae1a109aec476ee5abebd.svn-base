package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.view.ViewPager;
import android.view.View;
import android.widget.TextView;

import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseActivity;
import com.flyco.tablayout.CommonTabLayout;
import com.flyco.tablayout.listener.CustomTabEntity;
import com.flyco.tablayout.listener.OnTabSelectListener;

import java.util.ArrayList;

import app.odp.qidu.R;
import app.odp.qidu.adapter.MyPagerAdapter;
import app.odp.qidu.bean.TabEntity;
import app.odp.qidu.fragment.AnnouncementNoticeFragment;

/**
 * 公告通知
 */

public class NoticeTabActivity extends AbsBaseActivity implements OnTabSelectListener {
    private ArrayList<CustomTabEntity> mTabEntities = new ArrayList<>();
    private ArrayList<AnnouncementNoticeFragment> mFragments = new ArrayList<>();
    private String[] mTitles =null;
    private ViewPager vp;
    private MyPagerAdapter mAdapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tab_notice);

        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setText("公告通知");
        View back=findViewById(R.id.title_left_image);
        back.setOnClickListener(v -> {
            finish();
        });
        TextView right= (TextView) findViewById(R.id.title_right_text);
        right.setText("发布");
        right.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(),AnnouncementPublishActivity.class);
            intent.putExtra(IntentParams.KEY_PUBLISH_EDIT_ANNOUNCEMENT,AnnouncementPublishActivity.PUBLISH);
            getActivity().startActivity(intent);
        });
        mTitles = new String[]{"收到的通知", "发起的通知"};
        for (int i=0;i<mTitles.length;i++) {
            mFragments.add(AnnouncementNoticeFragment.getInstance(i+""));
        }

        vp= (ViewPager) findViewById(R.id.viewpager);
        mAdapter = new MyPagerAdapter(getSupportFragmentManager(),mFragments);
        vp.setAdapter(mAdapter);
        CommonTabLayout tabLayout = (CommonTabLayout) findViewById(R.id.tab_layout);
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
