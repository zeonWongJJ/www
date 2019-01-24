package com.app.base.mvp.contract;

import com.app.base.bean.AnnouncementBean;
import com.app.base.bean.Notice;
import com.app.base.bean.UserRealm;
import com.common.lib.basemvp.view.IUIView;

import java.util.HashMap;
import java.util.List;

/**
 * Created by 7du-28 on 2018/6/23.
 */

public class NoticeContract {

    public interface Presenter{
        void loadData(int pageIndex,HashMap<String,String> hashMap);

        //发布通知
        void publishNotice(boolean isEdit,HashMap<String,String> hashMap);
        void departmentAndMembers();
        //获取通知详情
        void getNoticeDetails(HashMap<String,String> hashMap);
    }

    public interface View extends IUIView {
        void noticeListData(int pageIndex,List<Notice> list);
        void showNoticeListFailure(Throwable throwable);

        void showUserListSuccess(List<UserRealm> list);
        void publishNoticeSuccess();
        void failure();
        //获取通知详情
        void getNoticeDetails(AnnouncementBean announcementBean);
    }
}
