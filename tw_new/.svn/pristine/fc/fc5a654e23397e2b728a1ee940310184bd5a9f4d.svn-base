package com.qidu.chat.service.temp;

import com.qidu.chat.api.MethodCallHelper;
import chat.rocket.core.temp.TempSpotlightRoomCaller;

public class DeafultTempSpotlightRoomCaller implements TempSpotlightRoomCaller {

  private final MethodCallHelper methodCallHelper;

  public DeafultTempSpotlightRoomCaller(MethodCallHelper methodCallHelper) {
    this.methodCallHelper = methodCallHelper;
  }

  @Override
  public void search(String term) {
    methodCallHelper.searchSpotlightRooms(term);
  }
}
