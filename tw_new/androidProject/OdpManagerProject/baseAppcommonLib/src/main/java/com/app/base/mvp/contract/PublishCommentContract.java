package com.app.base.mvp.contract;
import com.common.lib.basemvp.view.IUIView;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;

/**
 * 任务
 */

public class PublishCommentContract {

    //prensent接口省略
    public interface Presenter{
        //发布任务评论
        void publishTaskCommentRecord(HashMap<String,String> hashMap);
        //发布计划评论
        void publishPlanCommentRecord(HashMap<String,String> hashMap);
        //发布任务下部门动作记录
        void publishActionCommentRecord(HashMap<String,String> hashMap);
    }

    public interface View extends IUIView {
        void publishCommentSuccess(String msg);
        void publishCommentFailure(String tips);
    }
}
