package com.qidu.chat.fragment.oauth;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.helper.LogIfError;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.helper.TextUtils;
import com.qidu.chat.shared.BasePresenter;

import bolts.Task;
import io.reactivex.android.schedulers.AndroidSchedulers;
import org.json.JSONObject;

import chat.rocket.core.repositories.LoginServiceConfigurationRepository;

public class OAuthPresenter extends BasePresenter<OAuthContract.View>
    implements OAuthContract.Presenter {

  private final LoginServiceConfigurationRepository loginServiceConfigurationRepository;
  private final MethodCallHelper methodCallHelper;

  public OAuthPresenter(LoginServiceConfigurationRepository loginServiceConfigurationRepository,
                        MethodCallHelper methodCallHelper) {
    this.loginServiceConfigurationRepository = loginServiceConfigurationRepository;
    this.methodCallHelper = methodCallHelper;
  }

  @Override
  public void loadService(String serviceName) {
    addSubscription(
        loginServiceConfigurationRepository.getByName(serviceName)
            .subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
            .observeOn(AndroidSchedulers.mainThread())
            .subscribe(
                optional -> {
                  if (optional.isPresent()) {
                    view.showService(optional.get());
                  } else {
                    view.close();
                  }
                },
                Logger::report
            )
    );
  }

  @Override
  public void login(JSONObject credentialJsonObject) {
    if (credentialJsonObject == null || !credentialJsonObject.optBoolean("setCredentialToken")) {
      view.showLoginError();
      return;
    }

    final String credentialToken = credentialJsonObject.optString("credentialToken");
    final String credentialSecret = credentialJsonObject.optString("credentialSecret");

    if (TextUtils.isEmpty(credentialToken) || TextUtils.isEmpty(credentialSecret)) {
      view.showLoginError();
      return;
    }

    /*view.showLoginDone();

    methodCallHelper.loginWithOAuth(credentialToken, credentialSecret)
        .continueWith(new LogIfError());*/
    methodCallHelper.loginWithOAuth(credentialToken, credentialSecret)
            //.onSuccessTask(task -> methodCallHelper.setUsername(username)) //TODO: should prompt!

            //.continueWith(task -> methodCallHelper.loginWithToken(task.getResult())
            //.continueWith(task -> methodCallHelper.joinDefaultChannels())
            .continueWith(task -> {
              view.showLoginDone();
              return Task.forResult(task.getResult());
            })
            .continueWith(new LogIfError());

  }
}
