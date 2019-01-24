package com.app.base.mvp.presenter;

import android.text.TextUtils;
import android.util.Log;


import com.app.base.bean.StructureBean;
import com.app.base.bean.Task;
import com.app.base.mvp.contract.EditMapContract;
import com.app.base.netUtil.StructureHttpUtil;
import com.app.base.treeview.model.NodeModel;
import com.app.base.treeview.model.TreeModel;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ToastUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Stack;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by owant on 21/03/2017.
 */
public class EditMapPresenter extends BasePresenter<EditMapContract.View> implements EditMapContract.Presenter{
    private AbsBaseActivity activity;
    private TreeModel<StructureBean> mTreeModel;

    public EditMapPresenter(AbsBaseActivity activity) {
        this.activity = activity;
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        mTreeModel = null;
    }

    @Override
    public void createDefaultTreeModel() {

    }

    @Override
    public void addNote() {

    }

    @Override
    public void taskListByStructureId(HashMap<String, String> hashMap) {
        activity.showProgressDialog();
        Disposable disposable=StructureHttpUtil.getInstance().taskListSubNode(hashMap, new DisposableObserver<List<Task>>() {
            @Override
            public void onNext(List<Task> taskList) {
                activity.dismissProgressDialog();
                mView.taskListByStructureId(taskList);
            }

            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onComplete() {

            }
        },Task.class);
        mCompositeSubscription.add(disposable);
    }

    //添加节点下级
    @Override
    public void addSubNote(final String nodeValue, final String project_id, final String parent_id) {
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("structure_name",nodeValue);
        hashMap.put("project_id",project_id);
        if(parent_id!=null){
            hashMap.put("parent_id",parent_id);
        }
        Log.i("aaaaaaaa",hashMap.toString());
        Disposable disposable= StructureHttpUtil.getInstance().structureAddChildrenNode(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                activity.dismissProgressDialog();
                try {
                    JSONObject jsonObject=new JSONObject(s);
                    String structure_id=jsonObject.getString("structure_id");
                    mView.showAddSubNoteSuccess(nodeValue,project_id,parent_id,structure_id);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                ToastUtils.show("已经成功添加节点");
            }
            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void editNote(final StructureBean structureBean) {
        activity.showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("structure_id",structureBean.getStructure_id());
        hashMap.put("structure_name",structureBean.getStructure_name());
        StructureHttpUtil.getInstance().editSubNode(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                activity.dismissProgressDialog();
                mView.editNodeSuccess(structureBean);
                ToastUtils.show("编辑计划成功");
            }
            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onComplete() {

            }
        },String.class);
    }

    @Override
    public void focusMid() {
        mView.focusingMid();
    }

    @Override
    public void deleteSubNode(final NodeModel<StructureBean> nodeModel) {
        activity.showProgressDialog();
        final StructureBean structureBean=nodeModel.getValue();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("structure_id",structureBean.getStructure_id());
        Disposable disposable= StructureHttpUtil.getInstance().deleteSubNode(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                activity.dismissProgressDialog();
                mView.deleteSubNodeSuccess(nodeModel);
                ToastUtils.show(s);
            }
            @Override
            public void onError(Throwable e) {
                activity.dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void structureAllNode(HashMap<String,String> hashMap) {
        Disposable disposable= StructureHttpUtil.getInstance().structureAllNode(hashMap, new DisposableObserver<List<StructureBean>>() {
            @Override
            public void onNext(List<StructureBean> list) {
                mView.setTreeViewData(list);
            }

            @Override
            public void onError(Throwable e) {
                mView.onFailure(e);
            }

            @Override
            public void onComplete() {

            }
        },StructureBean.class);
        mCompositeSubscription.add(disposable);
    }


    private boolean isEqualsOldTreeModel(TreeModel<StructureBean> mOldTreeModel) {
        boolean equals = false;
        TreeModel<StructureBean> temp = mTreeModel;
        TreeModel<StructureBean> compareTemp = mOldTreeModel;

        StringBuffer tempBuffer = new StringBuffer();
        Stack<NodeModel<StructureBean>> stack = new Stack<>();
        NodeModel<StructureBean> rootNode = temp.getRootNode();
        stack.add(rootNode);
        while (!stack.isEmpty()) {
            NodeModel<StructureBean> pop = stack.pop();
            tempBuffer.append(pop.value);
            LinkedList<NodeModel<StructureBean>> childNodes = pop.getChildNodes();
            for (NodeModel<StructureBean> item : childNodes) {
                stack.add(item);
            }
        }

        StringBuffer compareTempBuffer = new StringBuffer();
        Stack<NodeModel<StructureBean>> stackThis = new Stack<>();
        NodeModel<StructureBean> rootNodeThis = compareTemp.getRootNode();
        stackThis.add(rootNodeThis);
        while (!stackThis.isEmpty()) {
            NodeModel<StructureBean> pop = stackThis.pop();
            compareTempBuffer.append(pop.value.getStructure_id());
            LinkedList<NodeModel<StructureBean>> childNodes = pop.getChildNodes();
            for (NodeModel<StructureBean> item : childNodes) {
                stackThis.add(item);
            }
        }

        if (compareTempBuffer.toString().equals(tempBuffer.toString())) {
            equals = true;
        }
        return equals;
    }


    @Override
    public void setTreeModel(TreeModel<StructureBean> treeModel) {
        mTreeModel = treeModel;
        mView.setTreeViewData(mTreeModel);
    }

    @Override
    public TreeModel<StructureBean> getTreeModel() {
        return mTreeModel;
    }


    @Override
    public void onCreate() {

    }

    @Override
    public void loadData() {

    }
}
