package com.app.base.mvp.contract;

import com.app.base.bean.Comment;
import com.app.base.bean.PlanComment;
import com.common.lib.basemvp.view.IUIView;

import java.util.HashMap;
import java.util.List;


/**
 * 获取评论列表
 */

public class CommentListContract {


    public interface Presenter{
        void loadData(int pageIndex,int pageSize,String task_id,String department);
        void loadPlanData(int pageIndex,int pageSize,String task_id,String department);

        void loadActionRecordList(final int pageIndex,int pageSize,String task_id,String department,String actionType);
    }

    public interface View extends IUIView {
        void commentListData(int pageIndex, List<Comment> list);
        void commentPlanListData(int pageIndex, List<PlanComment> list);
        void onFailure(Throwable throwable);
    }
}
