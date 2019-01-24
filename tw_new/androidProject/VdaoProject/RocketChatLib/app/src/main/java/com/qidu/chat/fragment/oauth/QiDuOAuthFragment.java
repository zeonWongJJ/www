package com.qidu.chat.fragment.oauth;

import chat.rocket.core.models.LoginServiceConfiguration;
import okhttp3.HttpUrl;

public class QiDuOAuthFragment extends AbstractOAuthFragment {

  @Override
  protected String getOAuthServiceName() {
    return "vv";
  }

  @Override
  protected String generateURL(LoginServiceConfiguration oauthConfig) {
    return new HttpUrl.Builder().scheme("http")
        .host("wofei_wap.7dugo.com")
        .addPathSegment("oauth2_authorize")
        .addQueryParameter("client_id", oauthConfig.getKey())
         //.addQueryParameter("redirect_uri","http://" + hostname + "/_oauth/vv")//http://14.152.90.114:88/_oauth/vv
            .addQueryParameter("redirect_uri","https://vdao.7dugo.com/_oauth/vv")
            .addQueryParameter("response_type", "code")

        .addQueryParameter("scope", "openid")//user:email
        .addQueryParameter("state", getStateString())
        .build()
        .toString();
    //重定向地址 http://192.168.1.30:80/_oauth/vv
    //return "http://wofei_wap.7dugo.com/oauth2_authorize?client_id=vfei&redirect_uri=http://192.168.1.30:80/_oauth/vv&response_type=code&state=eyJsb2dpblN0eWxlIjoicG9wdXAiLCJjcmVkZW50aWFsVG9rZW4iOiItaElyOHQ0THZRTzE4MzMxMUtpaWZsU0otb0VCZkUtOVpHaGU1VUJ4UVpRIiwiaXNDb3Jkb3ZhIjpmYWxzZX0=&scope=";
    /*return new HttpUrl.Builder().scheme("http")
            .host("wofei_wap.7dugo.com")
            //.addPathSegment("v2.2")
            //.addPathSegment("dialog")
            .addPathSegment("oauth2_authorize")
            .addQueryParameter("client_id", oauthConfig.getKey())
            .addQueryParameter("redirect_uri", "http://wofei_pc.7dugo.com/oauth_test.html")
            .addQueryParameter("display", "popup")
            .addQueryParameter("scope", "user:email")
            .addQueryParameter("state", *//*getStateString()*//*"xyz")
            .build()
            .toString();*/
    //http://wofei_pc.7dugo.com/oauth_test.html
    ////return "http://wofei_wap.7dugo.com/oauth2_authorize.html?response_type=code&client_id=vfei&state=xyz";

  }
}
