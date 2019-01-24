package com.qidu.chat.fragment.server_config;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.constraint.ConstraintLayout;
import android.support.design.widget.Snackbar;
import android.support.v4.app.Fragment;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.qidu.chat.api.MethodCallHelper;
import com.qidu.chat.layouthelper.oauth.OAuthProviderInfo;

import java.util.HashMap;
import java.util.List;
import com.qidu.chat.R;
import chat.rocket.android.log.RCLog;
import chat.rocket.core.models.LoginServiceConfiguration;
import chat.rocket.persistence.realm.repositories.RealmLoginServiceConfigurationRepository;
import chat.rocket.persistence.realm.repositories.RealmPublicSettingRepository;

/**
 * Login screen.
 */
public class LoginFragment extends AbstractServerConfigFragment implements LoginContract.View {

  private LoginContract.Presenter presenter;
  private ConstraintLayout container;
  private View waitingView;
  private TextView txtUsername;
  private TextView txtPasswd;

  @Override
  protected int getLayout() {
    return R.layout.fragment_login;
  }

  @Override
  public void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);

    presenter = new LoginPresenter(
        new RealmLoginServiceConfigurationRepository(hostname),
        new RealmPublicSettingRepository(hostname),
        new MethodCallHelper(getContext(), hostname)
    );
  }

  @Override
  protected void onSetupView() {
    container = rootView.findViewById(R.id.container);

    Button btnEmail = rootView.findViewById(R.id.btn_login_with_email);
    Button btnUserRegistration = rootView.findViewById(R.id.btn_user_registration);
    txtUsername = rootView.findViewById(R.id.editor_username);
    txtPasswd = rootView.findViewById(R.id.editor_passwd);
    waitingView = rootView.findViewById(R.id.waiting);

    btnEmail.setOnClickListener(view ->
        presenter.login(txtUsername.getText().toString(), txtPasswd.getText().toString()));

    btnUserRegistration.setOnClickListener(view ->
        UserRegistrationDialogFragment.create(hostname, txtUsername.getText().toString(), txtPasswd.getText().toString())
        .show(getFragmentManager(), "UserRegistrationDialogFragment"));
  }

  @Override
  public void showLoader() {
    container.setVisibility(View.GONE);
    waitingView.setVisibility(View.VISIBLE);
  }

  @Override
  public void hideLoader() {
    waitingView.setVisibility(View.GONE);
    container.setVisibility(View.VISIBLE);
  }

  @Override
  public void showError(String message) {
    Snackbar.make(rootView, message, Snackbar.LENGTH_SHORT).show();
  }

  @Override
  public void showLoginServices(List<LoginServiceConfiguration> loginServiceList) {
    HashMap<String, View> viewMap = new HashMap<>();
    HashMap<String, Boolean> supportedMap = new HashMap<>();
    for (OAuthProviderInfo info : OAuthProviderInfo.LIST) {//第三方登录例如 github
      viewMap.put(info.serviceName, rootView.findViewById(info.buttonId));
      supportedMap.put(info.serviceName, false);
    }

    for (LoginServiceConfiguration authProvider : loginServiceList) {
      for (OAuthProviderInfo info : OAuthProviderInfo.LIST) {
        if (!supportedMap.get(info.serviceName)
            && info.serviceName.equals(authProvider.getService())) {
          supportedMap.put(info.serviceName, true);
          viewMap.get(info.serviceName).setOnClickListener(view -> {
            Fragment fragment = null;
            try {
              fragment = info.fragmentClass.newInstance();
            } catch (Exception exception) {
              RCLog.w(exception, "failed to create new Fragment");
            }
            if (fragment != null) {
              Bundle args = new Bundle();
              args.putString("hostname", hostname);
              fragment.setArguments(args);
              showFragmentWithBackStack(fragment);
            }
          });
          viewMap.get(info.serviceName).setVisibility(View.VISIBLE);
        }
      }
    }

    for (OAuthProviderInfo info : OAuthProviderInfo.LIST) {
      if (!supportedMap.get(info.serviceName)) {
        viewMap.get(info.serviceName).setVisibility(View.GONE);
      }
    }
  }

  @Override
  public void showTwoStepAuth() {
    showFragmentWithBackStack(TwoStepAuthFragment.create(
        hostname, txtUsername.getText().toString(), txtPasswd.getText().toString()
    ));
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
}
