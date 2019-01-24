package com.qidu.chat.service.temp;

import com.qidu.chat.api.MethodCallHelper;

import chat.rocket.core.temp.TempSpotlightUserCaller;

public class DefaultTempSpotlightUserCaller implements TempSpotlightUserCaller {

  private final MethodCallHelper methodCallHelper;

  public DefaultTempSpotlightUserCaller(MethodCallHelper methodCallHelper) {
    this.methodCallHelper = methodCallHelper;
  }

  @Override
  public void search(String term) {
    methodCallHelper.searchSpotlightUsers(term);
  }
}
