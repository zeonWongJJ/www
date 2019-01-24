package com.qidu.chat.fragment.sidebar;

import android.support.annotation.NonNull;

import com.qidu.chat.shared.BaseContract;

import java.util.List;

import chat.rocket.core.models.User;
import io.reactivex.Flowable;

/**
 * Created by 7du-28 on 2017/11/8.
 */

public interface UserMainContract {

    interface View extends BaseContract.View {
        void show(User user);
    }

    interface Presenter extends BaseContract.Presenter<UserMainContract.View> {

        void onUserOnline();

        void onUserAway();

        void onUserBusy();

        void onUserOffline();

        void onLogout();
    }
}
