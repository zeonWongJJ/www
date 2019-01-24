package com.qidu.chat.api.rest;

import com.qidu.chat.helper.TextUtils;

import java.io.IOException;

import okhttp3.Interceptor;
import okhttp3.Request;
import okhttp3.Response;

public class CookieInterceptor implements Interceptor {

  private final CookieProvider cookieProvider;

  public CookieInterceptor(CookieProvider cookieProvider) {
    this.cookieProvider = cookieProvider;
  }

  @Override
  public Response intercept(Chain chain) throws IOException {
    if (chain.request().url().host().equals(cookieProvider.getHostname())) {
      final String cookie = cookieProvider.getCookie();

      if (!TextUtils.isEmpty(cookie)) {
        Request newRequest = chain.request().newBuilder()
            .header("Cookie", cookie)
            .build();
        return chain.proceed(newRequest);
      }
    }

    return chain.proceed(chain.request());
  }
}
