package com.app.base.flow;


import com.app.base.bean.UserRealm;

import java.util.List;

/**
 * Created by HanHailong on 15/10/20.
 */
public interface OnTagSelectListener {
    void onItemSelect(FlowTagLayout parent, List<UserRealm> selectedList);
}
