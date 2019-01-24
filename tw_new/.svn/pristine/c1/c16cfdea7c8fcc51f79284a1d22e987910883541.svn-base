package com.qidu.chat.fragment.oauth;

import org.json.JSONObject;

import com.qidu.chat.shared.BaseContract;
import chat.rocket.core.models.LoginServiceConfiguration;

public interface OAuthContract {

  interface View extends BaseContract.View {

    void showService(LoginServiceConfiguration oauthConfig);

    void close();

    void showLoginDone();

    void showLoginError();
  }

  interface Presenter extends BaseContract.Presenter<View> {

    void loadService(String serviceName);

    void login(JSONObject credentialJsonObject);
  }
}
