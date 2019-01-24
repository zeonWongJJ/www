package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.utils.IntentParams;
import com.app.base.utils.LoginUtil;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ToastUtils;
import com.flyco.tablayout.CommonTabLayout;
import com.flyco.tablayout.listener.CustomTabEntity;
import com.flyco.tablayout.listener.OnTabSelectListener;

import java.util.ArrayList;

import app.odp.qidu.R;
import app.odp.qidu.adapter.MyPagerAdapter;
import app.odp.qidu.bean.TabEntity;
import app.odp.qidu.fragment.ActionRecordListFragment;

/**
 * Created by 7du-28 on 2018/5/29.
 */

public class ActionRecordListActivity extends AbsBaseActivity implements OnTabSelectListener {
    private ArrayList<CustomTabEntity> mTabEntities = new ArrayList<>();
    private ArrayList<ActionRecordListFragment> mFragments = new ArrayList<>();
    private String[] mTitles =null;
    private ViewPager vp;
    private MyPagerAdapter mAdapter;
    private String department;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_action_record_list);
        String task_id=getIntent().getStringExtra(IntentParams.KEY_TASK_ID);
        department=getIntent().getStringExtra(IntentParams.KEY_DEPARTMENT);
        TextView right= (TextView) findViewById(R.id.title_right_text);
        right.setText("去记录");
        right.setBackground(getResources().getDrawable(R.drawable.shape_white_stroke_corner));
        right.setOnClickListener(v -> {
            Intent intent=new Intent(getActivity(),PublishCommentActivity.class);
            intent.putExtra(IntentParams.KEY_PUBLISH_COMMENT_OR_ACTION,PublishCommentActivity.PUBLISH_ACTION_COMMENT);
            intent.putExtra(IntentParams.KEY_TASK_ID,task_id);
            intent.putExtra(IntentParams.KEY_MEMBER_ID, LoginUtil.getInstance().getLoginUser().getMember_id()+"");
            //intent.putExtra(IntentParams.KEY_COMMENT_REPLY_ID,"");
            intent.putExtra(IntentParams.KEY_DEPARTMENT,/*LoginUtil.getInstance().getLoginUser().getDepartment_name()*/department);//不能传自己所在的部门
            startActivity(intent);
        });
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setText("动作记录");
        ImageView left= (ImageView) findViewById(R.id.title_left_image);
        left.setOnClickListener(v -> {
            finish();
        });

        mTitles = new String[]{"日志", "疑问","建议","bug"};
        //此处1,2,3,4和发布的那里对应
        mFragments.add(ActionRecordListFragment.getInstance("1",department,task_id));
        mFragments.add(ActionRecordListFragment.getInstance("2",department,task_id));
        mFragments.add(ActionRecordListFragment.getInstance("3",department,task_id));
        mFragments.add(ActionRecordListFragment.getInstance("4",department,task_id));
        vp= (ViewPager) findViewById(R.id.vp);
        mAdapter = new MyPagerAdapter(getSupportFragmentManager(),mFragments);
        vp.setAdapter(mAdapter);
        CommonTabLayout tabLayout = (CommonTabLayout) findViewById(R.id.sliding_tab_layout);
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
