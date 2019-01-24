package com.app.base.mvp.contract;

import com.app.base.bean.Participant;
import com.app.base.bean.Task;
import com.common.lib.basemvp.view.IUIView;

import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;

/**
 * 任务
 */

public class TaskContract {

    //prensent接口省略
    public interface Presenter{
        void loadData(int pageIndex);
        //发布任务
        void publishTask(boolean isEdit,HashMap<String,String> hashMap);

        void departmentAndMembers();

        //获取任务详情
        void getTaskDetails(HashMap<String,String> hashMap);
    }

    public interface View extends IUIView {
        //void showTaskListSuccess(int pageIndex, List<Task> list);
        void showParticipantListSuccess(List<Participant> list);
        void publishTaskSuccess();
        void failure();

        void getTaskDetails(Task task);
    }
}
