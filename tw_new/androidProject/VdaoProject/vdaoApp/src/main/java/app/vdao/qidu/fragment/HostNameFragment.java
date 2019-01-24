package app.vdao.qidu.fragment;

import android.content.Intent;

import com.gzqx.common.utils.HttpUrl;
import com.qidu.chat.fragment.add_server.InputHostnameFragment;

import app.vdao.qidu.activity.CordovaHomeActivity;

/**
 * Created by 7du-28 on 2017/11/7.
 */

public class HostNameFragment extends InputHostnameFragment{



    @Override
    protected void showMainHome() {
        Intent intent = new Intent(getActivity(), CordovaHomeActivity.class);
        intent.putExtra(HttpUrl.urlKey, HttpUrl.homeUrl);
        //intent.putExtra(MainActivity.EXTRA_FINISH_ON_BACK_PRESS, true);
        intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
        getActivity().startActivity(intent);
        getActivity().overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);
        getActivity().finish();
    }
}
