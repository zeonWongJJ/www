package com.app.base.mvp.contract;


import com.app.base.bean.StructureBean;
import com.app.base.bean.Task;
import com.app.base.treeview.model.NodeModel;
import com.app.base.treeview.model.TreeModel;
import com.common.lib.basemvp.view.IUIView;

import java.util.HashMap;
import java.util.List;

public class EditMapContract {

    public interface Presenter{
        //根据节点id获取相关任务
        void taskListByStructureId(HashMap<String,String> hashMap);
        //获取父节点下的所有子节点
        void structureAllNode(HashMap<String,String> hashMap);
        /**
         * 创建默认的TreeModel
         */
        void createDefaultTreeModel();

        /**
         * 添加节点
         */
        void addNote();

        /**
         * 添加子节点
         */
        void addSubNote(String nodeValue,String project_id,String structure_id);

        /**
         * 编辑节点
         */
        void editNote(StructureBean structureBean);

        /**
         * 对焦中心
         */
        void focusMid();

        //删除一个节点
        void deleteSubNode(NodeModel<StructureBean> nodeModel);


        /**
         * 设置树形模型
         *
         * @param treeModel
         */
        void setTreeModel(TreeModel<StructureBean> treeModel);

        /**
         * 获取树形模型
         *
         * @return 树形模型
         */
        TreeModel<StructureBean> getTreeModel();

    }

    public interface View extends IUIView {


        void editNodeSuccess(StructureBean value);

        /**
         * 设置树形结构数据
         *
         * @param treeModel
         */
        void setTreeViewData(TreeModel<StructureBean> treeModel);

        /**
         * 返回的树形结构数据，未处理
         *
         * @param data
         */
        void setTreeViewData(List<StructureBean> data);


        void deleteSubNodeSuccess(NodeModel<StructureBean> nodeModel);
        //添加下级节点
        void showAddSubNoteSuccess(String nodeValue,String project_id,String parent_id,String structure_id);
        /**
         * 显示添加节点
         */
        //void showAddNoteDialog();

        /**
         * 显示添加子节点
         */
        //void showAddSubNoteDialog();

        /**
         * 显示编辑节点
         */
        //void showEditNoteDialog();

        /**
         * 显示保存数据
         *
         * @param fileName
         */
        void showSaveFileDialog(String fileName);

        /**
         * 对焦中心
         */
        void focusingMid();

        /**
         * 获得默认root节点的text
         *
         * @return
         */
        //String getDefaultPlanStr();

        /**
         * 获得最近对焦
         *
         * @return
         */
        NodeModel<StructureBean> getCurrentFocusNode();
        void taskListByStructureId(List<Task> taskList);

        void onFailure(Throwable throwable);
    }
}
