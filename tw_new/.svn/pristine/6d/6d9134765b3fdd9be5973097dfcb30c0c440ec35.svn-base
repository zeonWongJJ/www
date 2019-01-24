package app.vdao.qidu.util;

import com.gzqx.common.datautil.SharedPreferencesUtils;
import com.gzqx.common.utils.CommonKey;


/**
 * 登陆管理
 */

public class AuthManager {
    /*protected static User user;
    public static void setCurrentUser(User currentUser){
        user=currentUser;
    }*/
    public static boolean isLogin(){
        boolean isLogin= (boolean) SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_IS_LOGIN,false);
        return isLogin;
    }

}
