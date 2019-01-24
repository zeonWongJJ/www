package com.qidu.chat.fragment.sidebar;

import android.app.ProgressDialog;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.util.Log;
import android.view.View;
import android.widget.CompoundButton;
import android.widget.Toast;

import com.gzqx.common.bean.CommonEventEntity;
import com.jakewharton.rxbinding2.widget.RxCompoundButton;
import com.luck.picture.lib.rxbus2.RxBus;
import com.luck.picture.lib.rxbus2.Subscribe;
import com.luck.picture.lib.rxbus2.ThreadMode;
import com.qidu.chat.R;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.fragment.AbstractFragment;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.renderer.UserRenderer;

import bean.DefaultEventEntity;
import chat.rocket.core.interactors.SessionInteractor;
import chat.rocket.core.models.User;
import chat.rocket.persistence.realm.repositories.RealmServerInfoRepository;
import chat.rocket.persistence.realm.repositories.RealmSessionRepository;
import chat.rocket.persistence.realm.repositories.RealmUserRepository;

/**
 * Created by 7du-28 on 2017/11/8.
 */

public abstract class UserRocketChatFragment extends AbstractFragment implements UserMainContract.View{
    private UserMainContract.Presenter presenter;
    protected String hostname;
    protected String HOSTNAME = "hostname";
    @Override
    protected int getLayout() {
        return R.layout.fragment_mine;
    }


    @Override
    public void onDestroyView() {
        super.onDestroyView();
        if (RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().unregister(this);
        }
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (!RxBus.getDefault().isRegistered(this)) {
            RxBus.getDefault().register(this);
        }
        RealmUserRepository userRepository = new RealmUserRepository(hostname);

        AbsoluteUrlHelper absoluteUrlHelper = new AbsoluteUrlHelper(
                hostname,
                new RealmServerInfoRepository(),
                userRepository,
                new SessionInteractor(new RealmSessionRepository(hostname))
        );
        presenter=new UserMainPresenter(userRepository,absoluteUrlHelper,new MethodCallHelper(getContext(), hostname));
    }
    @Override
    protected void onSetupView() {
        setupUserActionToggle();
        setupUserStatusButtons();
        setupLogoutButton();
    }

    @Override
    public void onResume() {
        super.onResume();
        presenter.bindView(this);
    }


    @Override
    public void onPause() {
        presenter.release();
        super.onPause();
    }
    private void setupUserActionToggle() {
        final CompoundButton toggleUserAction = rootView.findViewById(R.id.toggle_user_action);
        toggleUserAction.setFocusableInTouchMode(false);

        rootView.findViewById(R.id.user_info_container).setOnClickListener(view -> toggleUserAction.toggle());

        RxCompoundButton.checkedChanges(toggleUserAction)
                .compose(bindToLifecycle())
                .subscribe(
                        this::showUserActionContainer,
                        Logger::report
                );
    }
    public ProgressDialog progressDialog;
    public ProgressDialog showProgressDialog(CharSequence message) {
        progressDialog = new ProgressDialog(getActivity());
        progressDialog.setMessage(message);
        progressDialog.show();
        return progressDialog;
    }

    public void dismissProgressDialog() {
        if (progressDialog != null && progressDialog.isShowing()) {
            // progressDialog.hide();会导致android.view.WindowLeaked
            progressDialog.dismiss();
        }
    }
    public void showUserActionContainer(boolean show) {
        rootView.findViewById(R.id.user_action_outer_container)
                .setVisibility(show ? View.VISIBLE : View.GONE);
    }

    public void toggleUserActionContainer(boolean checked) {
        CompoundButton toggleUserAction = rootView.findViewById(R.id.toggle_user_action);
        toggleUserAction.setChecked(checked);
    }
    private void setupLogoutButton() {
        rootView.findViewById(R.id.btn_logout).setOnClickListener(view -> {
            showProgressDialog("正在退出...");
            presenter.onLogout();
            closeUserActionContainer();
            // destroy Activity on logout to be able to recreate most of the environment
        });
    }
    @Override
    public void show(User user) {
        rootView.findViewById(R.id.user_info_container).setVisibility(View.VISIBLE);
        onRenderCurrentUser(user);
        //updateRoomListMode();
    }
    private void setupUserStatusButtons() {
        rootView.findViewById(R.id.btn_status_online).setOnClickListener(view -> {
            presenter.onUserOnline();
            closeUserActionContainer();
        });
        rootView.findViewById(R.id.btn_status_away).setOnClickListener(view -> {
            presenter.onUserAway();
            closeUserActionContainer();
        });
        rootView.findViewById(R.id.btn_status_busy).setOnClickListener(view -> {
            presenter.onUserBusy();
            closeUserActionContainer();
        });
        rootView.findViewById(R.id.btn_status_invisible).setOnClickListener(view -> {
            presenter.onUserOffline();
            closeUserActionContainer();
        });
    }

    private void onRenderCurrentUser(User user) {
        if (user != null) {
            UserRenderer userRenderer = new UserRenderer(user);
            userRenderer.showAvatar(rootView.findViewById(R.id.current_user_avatar), hostname);
            userRenderer.showUsername(rootView.findViewById(R.id.current_user_name));
            userRenderer.showStatusColor(rootView.findViewById(R.id.current_user_status));
        }
    }
    public void closeUserActionContainer() {
        final CompoundButton toggleUserAction = rootView.findViewById(R.id.toggle_user_action);
        if (toggleUserAction != null && toggleUserAction.isChecked()) {
            toggleUserAction.setChecked(false);
        }
    }


}
