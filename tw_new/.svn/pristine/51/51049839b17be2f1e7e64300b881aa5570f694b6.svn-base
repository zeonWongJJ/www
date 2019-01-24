package app.vdao.qidu.common;

import android.content.Context;
import android.content.Intent;

import app.vdao.qidu.util.AuthManager;

public class AuthRedirectIntent extends Intent {
    public final static String REQUEST_CODE_KEY = "__REQUEST_CODE";
    public final static String WRAPPED_INTENT_KEY = "__WRAPPED_INTENT";
    protected int requestCode;
    protected Intent wrappedIntent;

    public AuthRedirectIntent(Intent wrappedIntent, int requestCode) {
        this.requestCode = requestCode;
        this.wrappedIntent = wrappedIntent;
        putExtra(WRAPPED_INTENT_KEY, wrappedIntent);
        putExtra(REQUEST_CODE_KEY, requestCode);
    }

    public static Intent make(Context context, Intent wrappedIntent) {
        return make(context, wrappedIntent, -1);
    }

    public static Intent make(Context context, Intent wrappedIntent, int requestCode) {
        if (AuthManager.isLogin()) {
            return wrappedIntent;
        } else {
            AuthRedirectIntent authRedirectIntent = new AuthRedirectIntent(wrappedIntent, requestCode);
            authRedirectIntent.setAction("com.gzqx.org.mvp.login.activity");
            return authRedirectIntent;
        }
    }
}