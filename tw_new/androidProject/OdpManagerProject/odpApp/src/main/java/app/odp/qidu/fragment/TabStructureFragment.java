package app.odp.qidu.fragment;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Project;
import com.app.base.bean.StructureBean;
import com.app.base.mvp.contract.ProjectPresenterContract;
import com.app.base.mvp.presenter.ProjectPresenterImpl;
import com.app.base.netUtil.StructureHttpUtil;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.widget.ProjectListPopupWindow;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.luck.picture.lib.immersive.ImmersiveManage;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import com.common.lib.basemvp.base.BaseFragment;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.activity.EditTreeActivity;
import app.odp.qidu.adapter.ChildrenProjectListAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/5/25.
 */

public class TabStructureFragment extends BaseFragment<ProjectPresenterImpl> implements ProjectPresenterContract.View{
    private String param;
    private ChildrenProjectListAdapter adapter;
    protected RecyclerView mRecyclerView;
    private TextView project_name;
    private ProjectListPopupWindow popupWindow;
    private Project selectProject;
    private SwipeRefreshLayout refresh_layout;
    public static TabStructureFragment getInstance(String param) {
        TabStructureFragment sf = new TabStructureFragment();
        sf.param = param;
        return sf;
    }

    @Subscribe(threadMode = ThreadMode.MAIN)
    public void eventBus(CommonEventEntity obj) {
        int code=obj.what;
        if(code== CommonKey.KEY_ADD_NODE_FOR_PROJECT){
            StructureBean structureBean= (StructureBean) obj.obj;
            /*String structureId=structureBean.getStructure_id();
            selectProject.getStructure().add(structureBean);*/
            adapter.addNewStructure(structureBean);

        }else if(code==CommonKey.KEY_DELETE_NODE_FOR_PROJECT){
            String structureId= (String) obj.obj;
            adapter.removeStructure(structureId);
        }/*else if(){
            //编辑项目节点的时候
        }*/
    }
    @Override
    protected void onVisible() {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.title_bg);
        LightStatusBarUtils.setLightStatusBar(getActivity(),false);
    }
    @Override
    protected void initViewsAndEvents(View view, Bundle savedInstanceState) {
        if (!RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().register(this);
        }
        refresh_layout=findView(R.id.refresh_layout);
        refresh_layout.setColorSchemeResources(R.color.red, R.color.red);
        project_name=view.findViewById(R.id.project_name);
        mRecyclerView=view.findViewById(R.id.recycler);
        adapter = new ChildrenProjectListAdapter(getActivity(),onAddClickListener);
        /*DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_one);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);*/
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        mRecyclerView.setAdapter(adapter);
        adapter.setOnItemClickListener((position, v) -> {
            StructureBean data=adapter.getDataList().get(position);
            Intent intent=new Intent(getActivity(), EditTreeActivity.class);
            intent.putExtra(IntentParams.KEY_STRUCTURE_TOP_PARENT_NAME,data.getStructure_name());
            intent.putExtra(IntentParams.KEY_STRUCTURE_TOP_PARENT_ID,data.getStructure_id());
            intent.putExtra(IntentParams.KEY_PROJECT_NAME,selectProject.getProject_name());
            intent.putExtra(IntentParams.KEY_PROJECT_ID,data.getProject_id());
            getActivity().startActivity(intent);
        });


        popupWindow=new ProjectListPopupWindow(getActivity());
        popupWindow.setOnItemMyListener((position,project)->{
            project_name.setText(project.getProject_name());
            selectProject=project;
            if(selectProject.getStructure()!=null){
                adapter.setList(selectProject.getStructure());
                adapter.notifyDataSetChanged();
            }
        });

        project_name.setOnClickListener(v -> {
            project_name.setCompoundDrawablesWithIntrinsicBounds(0,0,R.drawable.icon_white_arrow_up,0);
            popupWindow.show(project_name);
        });
        popupWindow.setOnDismissListener(()->{
            project_name.setCompoundDrawablesWithIntrinsicBounds(0,0,R.drawable.icon_white_arrow_down,0);
        });
        refresh_layout.setOnRefreshListener(()->{
            mPresenter.loadData();
        });
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_tab_structure,null);
    }

    @Override
    protected ProjectPresenterImpl initPresenter() {
        return new ProjectPresenterImpl();
    }

    ChildrenProjectListAdapter.onAddClickListener onAddClickListener=new ChildrenProjectListAdapter.onAddClickListener() {
        @Override
        public void onAddPicClick(int type, int position) {
            if(type==0){
                /*ToastUtils.show("添加子项目");
                Project task=new Project();
                task.setName("项目");
                task.setType(Project.AddItem);
                list.add(task);
                adapter.setList(list);
                adapter.notifyDataSetChanged();*/
                if(selectProject!=null){
                    Intent intent=new Intent(getActivity(), EditTreeActivity.class);
                    intent.putExtra(IntentParams.KEY_STRUCTURE_TOP_PARENT_NAME,selectProject.getProject_name());
                    //intent.putExtra(IntentParams.KEY_STRUCTURE_TOP_PARENT_ID,data.getStructure_id());
                    intent.putExtra(IntentParams.KEY_PROJECT_NAME,selectProject.getProject_name());
                    intent.putExtra(IntentParams.KEY_PROJECT_ID,selectProject.getProject_id());
                    intent.putExtra(IntentParams.KEY_PROJECT,selectProject);
                    getActivity().startActivity(intent);
                }
            }
        }
    };

    @Override
    public void projectList(List<Project> projectList) {
        refresh_layout.setRefreshing(false);
        if(projectList!=null&&!projectList.isEmpty()){
            popupWindow.setDataSource(projectList);
            popupWindow.setSelectPosition(0);//默认选择第一个
            selectProject=projectList.get(0);
            project_name.setText(selectProject.getProject_name());
            if(selectProject.getStructure()!=null){
                adapter.setList(selectProject.getStructure());
                adapter.notifyDataSetChanged();
            }
        }
    }

    @Override
    public void onError() {
        refresh_layout.setRefreshing(false);
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
        if (RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().unregister(this);
        }
    }
    //请求项目的下级节点
    /*private void structureNextNode(String structure_id,String project_id){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("project_id",project_id);
        hashMap.put("structure_id",structure_id);
        Disposable disposable= StructureHttpUtil.getInstance().structureAllNode(hashMap, new DisposableObserver<List<StructureBean>>() {
            @Override
            public void onNext(List<StructureBean> list) {
                dismissProgressDialog();
                adapter.setList(list);
                adapter.notifyDataSetChanged();
            }

            @Override
            public void onError(Throwable e) {

            }

            @Override
            public void onComplete() {

            }
        },StructureBean.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }*/
}
