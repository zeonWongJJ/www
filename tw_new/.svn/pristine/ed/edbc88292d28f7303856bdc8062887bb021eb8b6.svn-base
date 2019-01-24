package app.odp.qidu.fragment;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Project;
import com.app.base.bean.TopMenuItem;
import com.app.base.mvp.contract.ProjectPresenterContract;
import com.app.base.mvp.presenter.ProjectPresenterImpl;
import com.app.base.utils.CommonKey;
import com.app.base.utils.DataUtils;
import com.app.base.widget.TopMenuPopupWindow;
import com.common.lib.base.AbsBaseFragment;
import com.common.lib.base.BaseLazyFragment;
import com.common.lib.basemvp.base.BaseFragment;
import com.common.lib.utils.StatusBarUtil;
import com.luck.picture.lib.immersive.ImmersiveManage;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.luck.picture.lib.rxbus2.RxBus;
import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.PublishTaskActivity;


public class HomeFragment extends BaseFragment<ProjectPresenterImpl> implements ProjectPresenterContract.View{
    private FragmentManager manager;
    private TextView mActionButton;
    private int oldPosition=-1;
    private Fragment[] fragments=new Fragment[5];//添加fragment记得修改此个数
    private String param;
    private List<TopMenuItem> taskList;
    private String action="";
    private List<TopMenuItem> projectList=new ArrayList<>();
    private TopMenuPopupWindow leftWindow;
    public static HomeFragment getInstance(String param) {
        HomeFragment sf = new HomeFragment();
        sf.param = param;
        return sf;
    }
    @Override
    protected void onVisible() {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.title_bg);
        LightStatusBarUtils.setLightStatusBar(getActivity(),false);
        if(projectList.isEmpty()){
            mPresenter.loadData();
        }
    }


    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_home,container,false);
    }

    @Override
    protected void initViewsAndEvents(View view, Bundle savedInstanceState) {
        manager = getChildFragmentManager();
        TextView titleCenter=view.findViewById(R.id.title_center_text);
        titleCenter.setText("全部任务");
        View back=view.findViewById(R.id.title_left_image);
        back.setVisibility(View.GONE);
        TextView left=view.findViewById(R.id.title_left_text);
        left.setText("筛选");
        left.setOnClickListener(v -> {
            if(projectList.isEmpty()){
                return;
            }
            leftWindow=new TopMenuPopupWindow(getActivity()).builder();
            leftWindow.setSheetItems(projectList).setOnSheetItemClickListener((data, which) -> {
                left.setText(data.getTitle()+"");
                String projectId=data.getAction();
                CommonEventEntity eventEntity = new CommonEventEntity(CommonKey.KEY_CHANGE_PROJECT, projectId);
                RxBus.getDefault().post(eventEntity);
            }).showPopByLeftTop(v);
        });
        mActionButton =view.findViewById(R.id.fab);
        mActionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent=new Intent(getActivity(), PublishTaskActivity.class);
                startActivity(intent);
            }
        });
        ImageView right=view.findViewById(R.id.title_right_image);
        right.setImageResource(R.drawable.icon_more);
        action=TopMenuItem.ALL_TASK;
        taskList=DataUtils.taskList(action);//默认显示全部任务的时候
        right.setOnClickListener(v -> {
            new TopMenuPopupWindow(getActivity()).builder().setSheetItems(taskList).setOnSheetItemClickListener((data, which) -> {
                action=data.getAction();
                titleCenter.setText(data.getTitle());
                taskList= DataUtils.taskList(action);
                if(action.equals(TopMenuItem.ALL_TASK)){
                    showFragment(0);
                }else if(action.equals(TopMenuItem.PLAN_TASK)){
                    showFragment(1);
                }else if(action.equals(TopMenuItem.MY_TASK)){
                    showFragment(2);
                }else if(action.equals(TopMenuItem.BILLBOARD)){
                    showFragment(4);
                }else if(action.equals(TopMenuItem.MY_PUBLISH_TASK)){
                    showFragment(3);
                }
            }).showPop(v);
        });
        fragments[0]=TaskTabFragment.getInstance(TopMenuItem.ALL_TASK);//全部任务
        fragments[1]=TaskTabFragment.getInstance(TopMenuItem.PLAN_TASK);//我的任务
        fragments[2]=TaskTabFragment.getInstance(TopMenuItem.MY_TASK);//计划任务
        fragments[3]=TaskTabFragment.getInstance(TopMenuItem.MY_PUBLISH_TASK);//发布的任务
        fragments[4]=TaskHomeFragment.getInstance(TopMenuItem.BILLBOARD,"");//任务榜单
        showFragment(0);
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_home,null);
    }
    @Override
    protected ProjectPresenterImpl initPresenter() {
        return new ProjectPresenterImpl();
    }
    /**
     * 显示Fragment
     * @param position
     */
    protected void showFragment(int position){
        if(position==oldPosition){
            return;
        }
        String tag=makeFragmentTag(position);
        Fragment fragment=manager.findFragmentByTag(tag);
        Fragment oldFragment=manager.findFragmentByTag(makeFragmentTag(oldPosition));
        FragmentTransaction fragmentTransaction = manager.beginTransaction();
        if(fragment==null){
            fragment=fragments[position];
            fragmentTransaction.add(R.id.container, fragment, tag);
        }else{
            fragmentTransaction.show(fragment);
        }
        if(oldFragment!=null) {
            oldFragment.setMenuVisibility(false);
            oldFragment.setUserVisibleHint(false);
            fragmentTransaction.hide(oldFragment);
        }
        fragmentTransaction.commitAllowingStateLoss();
        manager.executePendingTransactions();
        fragment.setMenuVisibility(true);
        fragment.setUserVisibleHint(true);

        oldPosition=position;
    }

    private String makeFragmentTag(int index){
        return "app.odp.qidu.fragment["+index+"]";
    }


    @Override
    public void projectList(List<Project> list) {
        projectList.clear();
        for(int i=0;i<list.size();i++){
            Project project=list.get(i);
            TopMenuItem item=new TopMenuItem(project.getProject_name(),project.getProject_id()+"");
            projectList.add(item);
        }
    }

    @Override
    public void onError() {

    }
}
