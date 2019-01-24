package com.app.base.mvp.contract;

import com.app.base.bean.Participant;
import com.app.base.bean.PlanSubBean;
import com.common.lib.basemvp.view.IUIView;

import java.util.HashMap;
import java.util.List;

/**
 * 任务
 */

public class PlanContract {

    //prensent接口省略
    public interface Presenter{
        void loadData(int pageIndex);
        //发布任务
        void publishPlan(boolean isEdit, HashMap<String, String> hashMap);

        void departmentAndMembers();

        void planDetails(String planId);
    }

    public interface View extends IUIView {
        void showParticipantListSuccess(List<Participant> list);
        void publishPlanSuccess();
        void failure(Throwable e);

        void planDetails(PlanSubBean planSub);
    }
}
