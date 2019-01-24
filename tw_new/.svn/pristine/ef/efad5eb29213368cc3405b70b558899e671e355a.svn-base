package com.qidu.chat.activity;

import android.support.annotation.NonNull;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.service.ConnectivityManagerApi;
import com.qidu.chat.shared.BasePresenter;

import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;

import chat.rocket.core.interactors.SessionInteractor;

public class LoginPresenter extends BasePresenter<LoginContract.View>
    implements LoginContract.Presenter {

  private final String hostname;
  private final SessionInteractor sessionInteractor;
  private final ConnectivityManagerApi connectivityManagerApi;

  private boolean isLogging = false;

  public LoginPresenter(String hostname,
                        SessionInteractor sessionInteractor,
                        ConnectivityManagerApi connectivityManagerApi) {
    this.hostname = hostname;
    this.sessionInteractor = sessionInteractor;
    this.connectivityManagerApi = connectivityManagerApi;
  }

  @Override
  public void bindView(@NonNull LoginContract.View view) {
    super.bindView(view);

    connectivityManagerApi.keepAliveServer();

    if (hostname == null || hostname.length() == 0) {
      view.closeView();
      return;
    }

    if (isLogging) {
      return;
    }

    loadSessionState();
  }

  private void loadSessionState() {
    final Disposable subscription = sessionInteractor.getSessionState()
        .distinctUntilChanged()
        .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
        .observeOn(AndroidSchedulers.mainThread())
        .subscribe(
            state -> {
              switch (state) {
                case UNAVAILABLE:
                  isLogging = true;
                  view.showLogin(hostname);
                  break;
                case INVALID:
                  isLogging = false;
                  view.showRetryLogin(hostname);
                  break;
                case VALID:
                  isLogging = false;
                  view.closeView();
              }
            },
            Logger::report
        );

    addSubscription(subscription);
  }
}
