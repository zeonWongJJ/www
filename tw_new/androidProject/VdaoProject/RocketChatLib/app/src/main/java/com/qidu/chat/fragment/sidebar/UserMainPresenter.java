package com.qidu.chat.fragment.sidebar;


import android.support.annotation.NonNull;
import android.support.v4.util.Pair;
import android.util.Log;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.LogIfError;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.shared.BasePresenter;

import chat.rocket.core.models.User;
import chat.rocket.core.repositories.UserRepository;
import io.reactivex.Flowable;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;

public class UserMainPresenter extends BasePresenter<UserMainContract.View> implements UserMainContract.Presenter{
    private final UserRepository userRepository;
    private final AbsoluteUrlHelper absoluteUrlHelper;
    private final MethodCallHelper methodCallHelper;

    public UserMainPresenter(UserRepository userRepository, AbsoluteUrlHelper absoluteUrlHelper, MethodCallHelper methodCallHelper) {
        this.userRepository = userRepository;
        this.absoluteUrlHelper = absoluteUrlHelper;
        this.methodCallHelper = methodCallHelper;
    }

    @Override
    public void bindView(@NonNull UserMainContract.View view) {
        final Disposable subscription = Flowable.combineLatest(
                userRepository.getCurrent().distinctUntilChanged(),
                absoluteUrlHelper.getRocketChatAbsoluteUrl().toFlowable(),
                Pair::new
        )
                .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(pair -> view.show(pair.first.orNull()), Logger::report);
                /*.subscribe(
                        pair -> {
                            if(pair.first!=null){
                                //subscribeToRooms();
                                //Log.i("aaaa","getUsername:"+pair.first.get().getUsername()+"");
                            }
                            view.show(pair.first.orNull());
                        },
                        throwable -> {
                            Logger.report(throwable);
                        }
                );*/
        addSubscription(subscription);
    }

    @Override
    public void onUserOnline() {
        updateCurrentUserStatus(User.STATUS_ONLINE);
    }

    @Override
    public void onUserAway() {
        updateCurrentUserStatus(User.STATUS_AWAY);
    }

    @Override
    public void onUserBusy() {
        updateCurrentUserStatus(User.STATUS_BUSY);
    }

    @Override
    public void onUserOffline() {
        updateCurrentUserStatus(User.STATUS_OFFLINE);
    }

    @Override
    public void onLogout() {
        methodCallHelper.logout().continueWith(new LogIfError());
    }
    private void updateCurrentUserStatus(String status) {
        methodCallHelper.setUserStatus(status).continueWith(new LogIfError());
    }
}
