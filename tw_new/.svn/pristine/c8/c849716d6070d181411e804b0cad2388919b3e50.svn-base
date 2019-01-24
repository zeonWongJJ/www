package com.qidu.chat.fragment.add_server;

import android.util.Log;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.RocketChatCache;
import com.qidu.chat.api.rest.DefaultServerPolicyApi;
import com.qidu.chat.api.rest.ServerPolicyApi;
import com.qidu.chat.helper.OkHttpHelper;
import com.qidu.chat.helper.ServerPolicyApiValidationHelper;
import com.qidu.chat.helper.ServerPolicyHelper;
import com.qidu.chat.service.ConnectivityManagerApi;
import com.qidu.chat.shared.BasePresenter;

import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;

public class InputHostnamePresenter extends BasePresenter<InputHostnameContract.View> implements InputHostnameContract.Presenter {
  private final RocketChatCache rocketChatCache;
  private final ConnectivityManagerApi connectivityManager;

  public InputHostnamePresenter(RocketChatCache rocketChatCache, ConnectivityManagerApi connectivityManager) {
    this.rocketChatCache = rocketChatCache;
    this.connectivityManager = connectivityManager;
  }

  @Override
  public void connectTo(final String hostname) {
    view.showLoader();
    connectToEnforced(ServerPolicyHelper.enforceHostname(hostname));
  }

  public void connectToEnforced(final String hostname) {
    final ServerPolicyApi serverPolicyApi = new DefaultServerPolicyApi(OkHttpHelper.INSTANCE.getClientForUploadFile(), hostname);
    final ServerPolicyApiValidationHelper validationHelper = new ServerPolicyApiValidationHelper(serverPolicyApi);

    clearSubscriptions();

    final Disposable subscription = ServerPolicyHelper.isApiVersionValid(validationHelper)
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .doOnTerminate(() -> view.hideLoader())
        .subscribe(
            serverValidation -> {
              if (serverValidation.isValid()) {
                onServerValid(hostname, serverValidation.usesSecureConnection());
              } else {
                view.showInvalidServerError();
              }
            },
            throwable -> view.showConnectionError());
    addSubscription(subscription);
  }

  private void onServerValid(String hostname, boolean usesSecureConnection) {
    rocketChatCache.setSelectedServerHostname(hostname);

    String server = hostname.replace("/", ".");
    connectivityManager.addOrUpdateServer(server, server, !usesSecureConnection);
    connectivityManager.keepAliveServer();
    view.showHome();
  }
}