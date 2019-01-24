package com.app.base.utils;

import android.util.Log;

import com.app.base.bean.MemberRealm;
import com.app.base.bean.UserRealm;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.SharedPreferencesUtils;

import io.realm.Realm;

/**
 * Created by 7du-28 on 2018/6/8.
 */

public class LoginUtil {

    private static LoginUtil util;
    private MemberRealm loginUser;
    public static LoginUtil getInstance(){
        if(util==null){
            util=new LoginUtil();
        }
        return util;
    }

    public boolean isLogin(){
        boolean isLogin= (boolean) SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).getData(CommonKey.KEY_IS_LOGIN,false);
        return isLogin;
    }
    public MemberRealm getLoginUser(){
        if(loginUser==null){
            Realm mRealm=RealmUtils.getInstance().getRealm();
            loginUser = mRealm.where(MemberRealm.class).findFirst();
        }
        return loginUser;
    }
}
