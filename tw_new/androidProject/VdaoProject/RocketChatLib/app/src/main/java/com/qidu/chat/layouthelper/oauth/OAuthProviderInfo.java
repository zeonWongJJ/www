package com.qidu.chat.layouthelper.oauth;

import com.qidu.chat.fragment.oauth.FacebookOAuthFragment;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import com.qidu.chat.R;
import com.qidu.chat.fragment.oauth.AbstractOAuthFragment;
import com.qidu.chat.fragment.oauth.GitHubOAuthFragment;
import com.qidu.chat.fragment.oauth.GoogleOAuthFragment;
import com.qidu.chat.fragment.oauth.QiDuOAuthFragment;
import com.qidu.chat.fragment.oauth.TwitterOAuthFragment;

/**
 * ViewData model for OAuth login button.
 */
public class OAuthProviderInfo {
  private static final ArrayList<OAuthProviderInfo> _LIST = new ArrayList<OAuthProviderInfo>() {
    {
      add(new OAuthProviderInfo(
          "twitter", R.id.btn_login_with_twitter, TwitterOAuthFragment.class));
      add(new OAuthProviderInfo(
          "github", R.id.btn_login_with_github, GitHubOAuthFragment.class));
      add(new OAuthProviderInfo(
          "google", R.id.btn_login_with_google, GoogleOAuthFragment.class));
      add(new OAuthProviderInfo(
          "facebook", R.id.btn_login_with_facebook, FacebookOAuthFragment.class));
      add(new OAuthProviderInfo(
              "vv", R.id.btn_login_with_vv, QiDuOAuthFragment.class));
    }
  };
  public static final List<OAuthProviderInfo> LIST = Collections.unmodifiableList(_LIST);
  public String serviceName;
  public int buttonId;
  public Class<? extends AbstractOAuthFragment> fragmentClass;

  /**
   * Constructor with required parameters.
   */
  private OAuthProviderInfo(String serviceName, int buttonId,
                            Class<? extends AbstractOAuthFragment> fragmentClass) {
    this.serviceName = serviceName;
    this.buttonId = buttonId;
    this.fragmentClass = fragmentClass;
  }
}
