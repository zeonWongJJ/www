package app.odp.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.app.base.bean.CommonEventEntity;
import com.app.base.bean.Project;
import com.app.base.bean.StructureBean;
import com.app.base.bean.Task;
import com.app.base.bean.TypeSelect;
import com.app.base.mvp.contract.EditMapContract;
import com.app.base.mvp.presenter.EditMapPresenter;
import com.app.base.treeview.control.TwoFingersGestureDetector;
import com.app.base.treeview.model.NodeModel;
import com.app.base.treeview.model.TreeModel;
import com.app.base.treeview.view.RightTreeLayoutManager;
import com.app.base.treeview.view.TreeView;
import com.app.base.treeview.view.TreeViewItemClick;
import com.app.base.treeview.view.TreeViewItemLongClick;
import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.widget.EditNodeDialog;
import com.app.base.widget.TreeMapHandleMorePopupWindow;
import com.common.lib.basemvp.base.BaseActivity;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.AppDialog;
import com.google.gson.Gson;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.luck.picture.lib.rxbus2.RxBus;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.widget.NodeTaskListPopup;

/**
 * 编辑思维导图
 */

public class EditTreeActivity extends BaseActivity<EditMapPresenter> implements EditMapContract.View{
    private TreeView editMapTreeView;
    private EditText edit_add_sub_node;
    private View btn_handle_more,edit_layout,btn_add_sub;
    private NodeModel<StructureBean> root;
    private TreeModel treeModel;
    private String parentPlan,structureId,project_id,project_name;
    private View currentClickNodeView;//当前选择的节点view对象
    private NodeTaskListPopup popup;


    //
    private float tvWidth = -1f;
    private float tvHeight = -1f;

    private TwoFingersGestureDetector twoFingersGestureDetector;

    private float rotateDeg = 0f;
    private float scaleFactor = 1f;
    private float translateX = 0f;
    private float translateY = 0f;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        project_name=getIntent().getStringExtra(IntentParams.KEY_PROJECT_NAME);
        parentPlan=getIntent().getStringExtra(IntentParams.KEY_STRUCTURE_TOP_PARENT_NAME);//父节点id
        structureId=getIntent().getStringExtra(IntentParams.KEY_STRUCTURE_TOP_PARENT_ID);//父节点id
        project_id=getIntent().getStringExtra(IntentParams.KEY_PROJECT_ID);
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        View layout_parent=findView(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter=findView(R.id.title_center_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        ImageView left=findView(R.id.title_left_image);
        left.setImageResource(R.drawable.icon_back_black);
        left.setOnClickListener(v -> {
            finish();
        });
        popup=new NodeTaskListPopup(this);

        edit_layout=findViewById(R.id.edit_layout);
        /*TextView right=findView(R.id.title_right_text);
        right.setTextColor(getResources().getColor(R.color.blue));
        right.setText("保存");*/
        List<TypeSelect> moreList=new ArrayList<>();
        TypeSelect publishTask=new TypeSelect("publishTask","发布任务");
        moreList.add(publishTask);
        TypeSelect lookTask=new TypeSelect("lookTask","查看任务");
        moreList.add(lookTask);
        TypeSelect deleteTask=new TypeSelect("deleteTask","删除");
        moreList.add(deleteTask);
        TreeMapHandleMorePopupWindow treeMapHandleMorePopupWindow=new TreeMapHandleMorePopupWindow(getActivity());
        treeMapHandleMorePopupWindow.setOnItemMyListener((position, project) -> {
            treeMapHandleMorePopupWindow.dismiss();
            if(editMapTreeView.getCurrentFocusNode()==null){
                return;
            }
            if(project.getType().equals("publishTask")){
                StructureBean structureBean=editMapTreeView.getCurrentFocusNode().getValue();
                if(structureBean==null){
                    ToastUtils.show("请先选择节点");
                    return;
                }
                NodeModel<StructureBean> nodeRoot=editMapTreeView.getTreeModel().getRootNode();
                if(nodeRoot.getValue().getStructure_id()==null&&structureBean.getStructure_id()==null){
                    ToastUtils.show("顶级项目不能添加任务");
                }else {
                    Intent intent=new Intent(getActivity(), PublishTaskActivity.class);
                    intent.putExtra(IntentParams.KEY_NODE_ID,structureBean.getStructure_id());//传个节点id
                    intent.putExtra(IntentParams.KEY_NODE_NAME,structureBean.getStructure_name());//节点名称
                    intent.putExtra(IntentParams.KEY_NODE_PARENT_NAME,parentPlan);//父节点名称
                    intent.putExtra(IntentParams.KEY_NODE_PARENT_ID,structureId);//父节点id
                    intent.putExtra(IntentParams.KEY_PROJECT_NAME,project_name);//项目名称
                    intent.putExtra(IntentParams.KEY_PROJECT_ID,project_id);
                    intent.putExtra(IntentParams.KEY_HANDLE_TASK_TYPE,PublishTaskActivity.PUBLISH_BY_PROJECT_CHILD);
                    startActivity(intent);
                }
            }else if(project.getType().equals("deleteTask")){
                //StructureBean structureBean=editMapTreeView.getCurrentFocusNode().getValue();
                NodeModel<StructureBean> nodeModel=editMapTreeView.getCurrentFocusNode();
                StructureBean nodeItem=nodeModel.getValue();
                List<StructureBean> structure=nodeItem.getChildren();
                if(structure!=null){
                    if(structure.size()>0){
                        ToastUtils.show("该节点还有下级，不能直接删除");
                        return;
                    }
                }
                NodeModel<StructureBean> nodeRoot=editMapTreeView.getTreeModel().getRootNode();
                if(nodeRoot.getValue().getStructure_id()==null&&nodeItem.getStructure_id()==null){//选中当前节点是项目节点的时候
                    ToastUtils.show("无删除项目权限");
                    return;
                }
                if(structureId!=null&&structureId.equals(nodeItem.getStructure_id())){
                    ToastUtils.show("此根节点需要在项目节点下删除");
                    return;
                }
                mPresenter.deleteSubNode(nodeModel);
            }else if(project.getType().equals("lookTask")){

                StructureBean structureBean=editMapTreeView.getCurrentFocusNode().getValue();
                if(structureBean==null){
                    ToastUtils.show("请先选择节点");
                    return;
                }
                if(!TextUtils.isEmpty(structureBean.getStructure_id())){
                    HashMap<String,String> hashMap=new HashMap<>();
                    hashMap.put("structure_id",structureBean.getStructure_id());//1
                    mPresenter.taskListByStructureId(hashMap);
                }else {
                    ToastUtils.show("该节点无任务");
                }
            }
        });
        treeMapHandleMorePopupWindow.setDataSource(moreList);

        editMapTreeView = findView(R.id.edit_map_tree_view);
        twoFingersGestureDetector = new TwoFingersGestureDetector();
        twoFingersGestureDetector.setTwoFingersGestureListener(new TwoFingersGestureDetector.TwoFingersGestureListener() {
            @Override
            public void onDown(float downX, float downY, long downTime) {
                if (tvWidth == -1f) {
                    tvWidth = editMapTreeView.getWidth();
                    tvHeight = editMapTreeView.getHeight();
                }
            }
            @Override
            public void onMoved(float deltaMovedX, float deltaMovedY, long deltaMilliseconds) {
                editMapTreeView.setTranslationX(translateX += deltaMovedX);
                editMapTreeView.setTranslationY(translateY += deltaMovedY);
            }
            @Override
            public void onRotated(float deltaRotatedDeg, long deltaMilliseconds) {
                //editMapTreeView.setRotation(rotateDeg += deltaRotatedDeg);
            }
            @Override
            public void onScaled(float deltaScaledX, float deltaScaledY, float deltaScaledDistance, long deltaMilliseconds) {
                scaleFactor += deltaScaledDistance / tvWidth;
                editMapTreeView.setScaleX(scaleFactor);
                editMapTreeView.setScaleY(scaleFactor);
            }
            @Override
            public void onUp(float upX, float upY, long upTime, float xVelocity, float yVelocity) {

            }
            @Override
            public void onCancel() {}
        });
        int dx = ScreenUtils.dp2px(getApplicationContext(), 40);
        int dy = ScreenUtils.dp2px(getApplicationContext(), 40);
        int screenHeight = ScreenUtils.dp2px(getApplicationContext(), 480);
        editMapTreeView.setTreeLayoutManager(new RightTreeLayoutManager(dx, dy, screenHeight));
        editMapTreeView.setTreeViewItemLongClick(new TreeViewItemLongClick() {
            @Override
            public void onLongClick(View view) {
                //mEditMapPresenter.editNote();
                StructureBean structureBean=editMapTreeView.getCurrentFocusNode().getValue();
                if(structureBean!=null){
                    new EditNodeDialog.Builder(getActivity()).setCancel("取消").setOk("提交").setMsg(structureBean.getStructure_name()).setTitle("编辑节点").setClickListener(new EditNodeDialog.OnClickListener() {
                        @Override
                        public void onOkClick(String editContent) {
                            showProgressDialog();
                            structureBean.setStructure_name(editContent);
                            mPresenter.editNote(structureBean);

                        }
                        @Override
                        public void onCancelClick() {

                        }
                        @Override
                        public void onDismiss() {

                        }
                    }).create();
                }
            }
        });
        editMapTreeView.setTreeViewItemClick(new TreeViewItemClick() {
            @Override
            public void onItemClick(View item) {
                /*NodeModel<StructureBean> nodeModel=editMapTreeView.getCurrentFocusNode();
                ToastUtils.show(nodeModel.getValue().getStructure_name());*/
                currentClickNodeView=item;
                //taskListSubNode
            }
        });
        edit_add_sub_node=findView(R.id.edit_add_sub_node);
        edit_add_sub_node.setOnEditorActionListener((v, actionId, event) -> {
            if (actionId == EditorInfo.IME_ACTION_DONE) {   // 按下完成按钮，这里和上面imeOptions对应
                if(editMapTreeView.getCurrentFocusNode()==null){
                    ToastUtils.show("请先选择节点");
                    return false;
                }
                String nodeValue=edit_add_sub_node.getText().toString().trim();
                if(TextUtils.isEmpty(nodeValue)){
                    ToastUtils.show("节点不能为空");
                    return false;
                }
                StructureBean structureBean=editMapTreeView.getCurrentFocusNode().getValue();
                if(structureBean!=null){
                    addSubNode(nodeValue,structureBean.getProject_id(),structureBean.getStructure_id());
                }
                //
                return false;   //返回true，保留软键盘。false，隐藏软键盘
            }
            return true;
        });
        btn_add_sub=findView(R.id.btn_add_sub);
        btn_handle_more=findView(R.id.btn_handle_more);
        btn_add_sub.setOnClickListener(v -> {
            if(edit_layout.getVisibility()!=View.VISIBLE){
                edit_layout.setVisibility(View.VISIBLE);
            }
            if(editMapTreeView.getCurrentFocusNode()==null){
                ToastUtils.show("请先选择节点");
                return;
            }
            String nodeValue=edit_add_sub_node.getText().toString().trim();
            if(TextUtils.isEmpty(nodeValue)){
                ToastUtils.show("节点不能为空");
                return;
            }
            StructureBean structureBean=editMapTreeView.getCurrentFocusNode().getValue();
            if(structureBean!=null){
                addSubNode(nodeValue,structureBean.getProject_id(),structureBean.getStructure_id());
            }
        });
        btn_handle_more.setOnClickListener(v -> {
            treeMapHandleMorePopupWindow.show(v);
        });
        //String parentPlan="ODP项目管理系统";
        StructureBean rootBean=new StructureBean();
        rootBean.setStructure_name(parentPlan);
        if(structureId!=null){//
            rootBean.setStructure_id(structureId);
        }
        rootBean.setProject_id(project_id);
        root = new NodeModel<>(rootBean);
        treeModel = new TreeModel<>(root);

        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("project_id",project_id);
        if(structureId!=null){//不传表示为顶级项目添加节点
            hashMap.put("structure_id",structureId);
            showProgressDialog();
            mPresenter.structureAllNode(hashMap);
        }else {
            Project project= (Project) getIntent().getSerializableExtra(IntentParams.KEY_PROJECT);
            if(project.getStructure()!=null){
                if(project.getStructure().size()>0){
                    List<StructureBean> list=project.getStructure();
                    for(int i=0;i<list.size();i++){
                        StructureBean structureBean=list.get(i);
                        NodeModel<StructureBean> subNode = new NodeModel<>(structureBean);
                        treeModel.addNode(root,subNode);
                    }
                }
            }
            editMapTreeView.setTreeModel(treeModel);
        }

        /*for(int i=0;i<4;i++){
            NodeModel<String> subNode = new NodeModel<>("第一级子节点"+i);
            treeModel.addNode(root,subNode);
            for(int k=0;k<3;k++){
                NodeModel<String> subNode1 = new NodeModel<>("添加子第二级节点"+k);
                treeModel.addNode(subNode,subNode1);
            }

        }
        editMapTreeView.setTreeModel(treeModel);
        */

        /*TreeView相关方法
        * editMapTreeView.setTreeModel(treeModel);
        * editMapTreeView.addNode(value);
        * editMapTreeView.addSubNode(value);
        * editMapTreeView.deleteNode(model);
        * editMapTreeView.changeNodeValue(getCurrentFocusNode(), value);
        * editMapTreeView.focusMidLocation();
        * */
    }
    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        if(treeModel!=null){
            outState.putSerializable("tree_model", treeModel);
        }
        //Log.i(TAG, "onSaveInstanceState: 保持数据");
    }

    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState) {
        super.onRestoreInstanceState(savedInstanceState);
        Serializable saveZable = savedInstanceState.getSerializable("tree_model");
        if(saveZable!=null&&editMapTreeView!=null){
            treeModel=(TreeModel<StructureBean>)saveZable;
            editMapTreeView.setTreeModel(treeModel);
        }
    }

    private void addSubNode(String nodeValue,String projectId,String structureId){
        new AppDialog.Builder(this).setTitle("确定添加此子节点内容？").setMsg(nodeValue).setOk("确定").setCancel("取消").setClickListener(new AppDialog.OnClickListener() {
            @Override
            public void onOkClick() {
                hideKeyboard();
                mPresenter.addSubNote(nodeValue,projectId,structureId);
            }
            @Override
            public void onCancelClick() {

            }
            @Override
            public void onDismiss() {

            }
        }).create();
    }


    @Override
    public boolean onTouchEvent(MotionEvent event) {
        twoFingersGestureDetector.onTouchEvent(event);
        return super.onTouchEvent(event);
    }


    @Override
    public void showAddSubNoteSuccess(String nodeValue,String project_id,String parent_id,String structure_id) {
        StructureBean structureBean=new StructureBean();
        structureBean.setStructure_name(nodeValue);
        if(structure_id!=null){
            structureBean.setParent_id(parent_id);
        }
        structureBean.setStructure_id(structure_id);
        structureBean.setProject_id(project_id);
        editMapTreeView.addSubNode(structureBean);

        if(structureId==null){//如果是为项目添加下级节点，刷新页面
            CommonEventEntity eventEntity=new CommonEventEntity(CommonKey.KEY_ADD_NODE_FOR_PROJECT, structureBean);
            RxBus.getDefault().post(eventEntity);
        }

    }

    @Override
    public void editNodeSuccess(StructureBean value) {
        dismissProgressDialog();
        editMapTreeView.changeNodeValue(getCurrentFocusNode(), value);
    }

    @Override
    public void deleteSubNodeSuccess(NodeModel<StructureBean> nodeModel) {
        editMapTreeView.deleteNode(nodeModel);

        if(structureId==null){//如果是为项目添加下级节点，刷新页面
            StructureBean bean=nodeModel.getValue();
            CommonEventEntity eventEntity=new CommonEventEntity(CommonKey.KEY_DELETE_NODE_FOR_PROJECT, bean.getStructure_id());
            RxBus.getDefault().post(eventEntity);
        }
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.activity_edit_tree,null);
    }

    @Override
    protected EditMapPresenter initPresenter() {
        return new EditMapPresenter(this);
    }

    @Override
    public void setTreeViewData(TreeModel<StructureBean> treeModel) {

    }

    @Override
    public void setTreeViewData(List<StructureBean> list) {
        dismissProgressDialog();
        for(int i=0;i<list.size();i++){
            StructureBean structureBean=list.get(i);
            NodeModel<StructureBean> subNode = new NodeModel<>(structureBean);
            treeModel.addNode(root,subNode);
            if(list.get(i).getChildren()!=null&&!list.get(i).getChildren().isEmpty()){
                initNodeData(subNode,list.get(i).getChildren());
            }
        }
        editMapTreeView.setTreeModel(treeModel);
        //editMapTreeView.setTreeModel(treeModel.get);
    }

    @Override
    public void onFailure(Throwable throwable) {
        dismissProgressDialog();
        ToastUtils.show(throwable.getMessage());
    }

    /*NodeModel<String> subNode = new NodeModel<>("第一级子节点"+i);
                treeModel.addNode(root,subNode);
                for(int k=0;k<3;k++){
                    NodeModel<String> subNode1 = new NodeModel<>("添加子第二级节点"+k);
                    treeModel.addNode(subNode,subNode1);
                }*/
    private void initNodeData(NodeModel<StructureBean> parent,List<StructureBean> list){
        for(int i=0;i<list.size();i++){
            StructureBean structureBean=list.get(i);
            NodeModel<StructureBean> subNode = new NodeModel<>(structureBean);
            treeModel.addNode(parent,subNode);
            if(structureBean.getChildren()!=null&&structureBean.getChildren().isEmpty()){
                initNodeData(subNode,structureBean.getChildren());
            }
        }
    }
    @Override
    public void showSaveFileDialog(String fileName) {

    }

    @Override
    public void focusingMid() {

    }

    @Override
    public NodeModel<StructureBean> getCurrentFocusNode() {
        return editMapTreeView.getCurrentFocusNode();
    }


    @Override
    public void taskListByStructureId(List<Task> taskList) {
        if(taskList!=null&&!taskList.isEmpty()){
            if(currentClickNodeView!=null){
                popup.setDataSource(taskList);
                popup.show(currentClickNodeView);
            }
        }else {
            ToastUtils.show("此节点暂无任务");
        }
    }

}
