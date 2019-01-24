package app.odp.qidu;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Toast;

import app.odp.qidu.bean.TabEntity;
import app.odp.qidu.fragment.HomeFragment;
import app.odp.qidu.fragment.TabAchievementFragment;
import app.odp.qidu.fragment.TabMoreFragment;
import app.odp.qidu.fragment.TabPlanFragment;
import app.odp.qidu.fragment.TabStructureFragment;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import com.app.base.bean.Participant;
import com.app.base.bean.UserRealm;
import com.app.base.netUtil.HttpUtil;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.netUtil.VersionUpdateUtil;
import com.common.lib.base.BaseApplication;
import com.common.lib.basemvp.base.BaseActivity;
import com.common.lib.utils.ToastUtils;
import com.flyco.tablayout.CommonTabLayout;
import com.flyco.tablayout.listener.CustomTabEntity;
import com.flyco.tablayout.listener.OnTabSelectListener;
import com.common.lib.basemvp.presenter.BasePresenter;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

//realm socket.io
public class MainActivity extends BaseActivity<BasePresenter> {
    private ArrayList<Fragment> mFragments = new ArrayList<>();
    private ArrayList<CustomTabEntity> mTabEntities = new ArrayList<>();
    private CommonTabLayout mTabLayout_2;
    private String[] mTitles = {"任务", "计划","结构","绩效","更多"};
    private int[] mIconUnselectIds = {
            R.drawable.icon_tab_task_unselect,R.drawable.icon_tab_plan_unselect,R.drawable.icon_tab_structure_unselect,R.drawable.icon_tab_achievement_unselect, R.drawable.icon_tab_more_unselect};
    private int[] mIconSelectIds = {
            R.drawable.icon_tab_task_select, R.drawable.icon_tab_plan_select,R.drawable.icon_tab_structure_select,R.drawable.icon_tab_achievement_select,R.drawable.icon_tab_more};



    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        initDepartmentMember();
        mFragments.add(HomeFragment.getInstance("Switch ViewPager " + mTitles[0]));
        mFragments.add(TabPlanFragment.getInstance("Switch ViewPager " + mTitles[1]));
        //mFragments.add(TabNoticeFragment.getInstance("Switch ViewPager " + mTitles[2]));
        mFragments.add(TabStructureFragment.getInstance("Switch ViewPager " + mTitles[2]));
        mFragments.add(TabAchievementFragment.getInstance("Switch ViewPager " + mTitles[3]));
        mFragments.add(TabMoreFragment.getInstance("Switch ViewPager " + mTitles[4]));

        for (int i = 0; i < mTitles.length; i++) {
            mTabEntities.add(new TabEntity(mTitles[i], mIconSelectIds[i], mIconUnselectIds[i]));
        }

        mTabLayout_2 = (CommonTabLayout) findViewById( R.id.tl_2);
        //mTabLayout_2.setTabData(mTabEntities);
        mTabLayout_2.setTabData(mTabEntities, this, R.id.container, mFragments);
        //Random mRandom = new Random();
        mTabLayout_2.setOnTabSelectListener(new OnTabSelectListener() {
            @Override
            public void onTabSelect(int position) {
                mTabLayout_2.setCurrentTab(position);
            }

            @Override
            public void onTabReselect(int position) {
                /*if (position == 0) {
                    mTabLayout_2.showMsg(0, mRandom.nextInt(100) + 1);
//                    UnreadMsgUtils.show(mTabLayout_2.getMsgView(0), mRandom.nextInt(100) + 1);
                }*/
            }
        });

        //mTabLayout_2.showMsg(2, 55);
        //mTabLayout_2.setMsgMargin(2, -5, 5);
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
        VersionUpdateUtil.getInstance(getActivity()).checkVersion();
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.activity_main,null);
        return view;
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

    //https://vdao-mobile.7dugo.com//store_api-020


    private long exitTime = 0;
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if(keyCode == KeyEvent.KEYCODE_BACK && event.getAction() == KeyEvent.ACTION_DOWN){
            if((System.currentTimeMillis()-exitTime) > 2000){
                Toast.makeText(this, "再按一次退出程序", Toast.LENGTH_SHORT).show();
                exitTime = System.currentTimeMillis();
            } else {
                BaseApplication.getInstance().exit();
            }
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
    //初始化部门人员缓存
    private void initDepartmentMember(){
        HashMap<String, String> hashMap=new HashMap<>();
        Disposable disposable=MemberHttpUtil.getInstance().departmentAndMembers(hashMap, new DisposableObserver<List<Participant>>() {
            @Override
            public void onNext(List<Participant> list) {

            }
            @Override
            public void onError(Throwable e) {

            }
            @Override
            public void onComplete() {

            }
        });
        mPresenter.getCompositeSubscription().add(disposable);
    }

}
