package com.qidu.chat.fragment.server_config;

import android.support.annotation.NonNull;

import com.hadisatrio.optional.Optional;
import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.helper.TextUtils;
import com.qidu.chat.shared.BasePresenter;

import io.reactivex.android.schedulers.AndroidSchedulers;

import chat.rocket.core.interactors.SessionInteractor;
import chat.rocket.core.models.Session;

public class RetryLoginPresenter extends BasePresenter<RetryLoginContract.View>
    implements RetryLoginContract.Presenter {

  private final SessionInteractor sessionInteractor;
  private final MethodCallHelper methodCallHelper;

  public RetryLoginPresenter(SessionInteractor sessionInteractor,
                             MethodCallHelper methodCallHelper) {
    this.sessionInteractor = sessionInteractor;
    this.methodCallHelper = methodCallHelper;
  }

  @Override
  public void bindView(@NonNull RetryLoginContract.View view) {
    super.bindView(view);

    subscribeToDefaultSession();
  }

  @Override
  public void onLogin(String token) {
    view.showLoader();

    methodCallHelper.loginWithToken(token)
        .continueWith(task -> {
          if (task.isFaulted()) {
            view.hideLoader();
          }
          return null;
        });
  }

  private void subscribeToDefaultSession() {
    addSubscription(
        sessionInteractor.getDefault()
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                this::onSession,
                Logger::report
            )
    );
  }

  private void onSession(Optional<Session> sessionOptional) {
    if (!sessionOptional.isPresent()) {
      return;
    }

    final Session session = sessionOptional.get();

    final String token = session.getToken();
    if (!TextUtils.isEmpty(token)) {
      view.showRetry(token);
    }

    final String errorMessage = session.getError();
    if (!TextUtils.isEmpty(errorMessage)) {
      view.showError(errorMessage);
    }
  }
}
