package com.qidu.chat.fragment.add_server;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.constraint.ConstraintLayout;
import android.support.design.widget.Snackbar;
import android.util.Log;
import android.view.View;
import android.widget.TextView;

import com.gzqx.common.datautil.AppGlobal;
import com.gzqx.common.sysutil.CrashHandler;
import com.gzqx.common.sysutil.PermissionUtils;
import com.qidu.chat.activity.ChatMainActivity;
import com.qidu.chat.helper.TextUtils;
import com.qidu.chat.service.ConnectivityManager;

import com.qidu.chat.BuildConfig;
import com.qidu.chat.LaunchUtil;
import com.qidu.chat.R;
import com.qidu.chat.RocketChatCache;
import com.qidu.chat.fragment.AbstractFragment;

import icepick.State;

/**
 * Input server host.
 */
public class InputHostnameFragment extends AbstractFragment implements InputHostnameContract.View {

  private InputHostnameContract.Presenter presenter;
  private ConstraintLayout container;
  //private View waitingView;
  private Handler handler=new Handler();
  public InputHostnameFragment() {}
  @State
  protected String hostname;
  @Override
  public void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);

    Context appContext = getContext().getApplicationContext();
    presenter = new InputHostnamePresenter(new RocketChatCache(appContext), ConnectivityManager.getInstance(appContext));
  }

  @Override
  protected int getLayout() {
    return R.layout.fragment_input_hostname;
  }

  @Override
  protected void onSetupView() {
    //setupVersionInfo();

    container = rootView.findViewById(R.id.container);
    //waitingView = rootView.findViewById(R.id.waiting);
    hostname = new RocketChatCache(getActivity()).getSelectedServerHostname();


  }

  /*private void setupVersionInfo() {
    TextView versionInfoView = (TextView) rootView.findViewById(R.id.version_info);
    versionInfoView.setText(getString(R.string.version_info_text, BuildConfig.VERSION_NAME));
  }*/

  private void handleConnect() {
    presenter.connectTo("http://vdao.7dugo.com/");
  }
  private PermissionUtils.PermissionGrant mPermissionGrant = new PermissionUtils.PermissionGrant() {
    @Override
    public void onPermissionGranted(int requestCode) {
      switch (requestCode) {
        case PermissionUtils.CODE_MULTI_PERMISSION:
          init();
          break;
        default:
          break;
      }
    }
  };
  private void init(){
    AppGlobal.initGlobal(getActivity());
    // 异常处理，不需要处理时注释掉这两句即可！
    CrashHandler crashHandler = CrashHandler.getInstance();
    // 注册crashHandler
    crashHandler.init(getActivity());

    if(hostname==null){
      handleConnect();
    }else {
      showHome();
    }
  }
  @Override
  public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
    super.onViewCreated(view, savedInstanceState);
    presenter.bindView(this);
    handler.postDelayed(new Runnable() {
      @Override
      public void run() {
        String[] requestPermissions = {
                PermissionUtils.PERMISSION_ACCESS_FINE_LOCATION,
                PermissionUtils.PERMISSION_ACCESS_COARSE_LOCATION,
                PermissionUtils.PERMISSION_READ_EXTERNAL_STORAGE,
                PermissionUtils.PERMISSION_WRITE_EXTERNAL_STORAGE,
                PermissionUtils.PERMISSION_CAMERA
        };
        PermissionUtils.requestMultiPermissions(InputHostnameFragment.this,null,requestPermissions,mPermissionGrant);
        //requestPermissions(requestPermissions,100);
      }
    }, 2000);
  }

  @Override
  public void onDestroyView() {
    presenter.release();
    super.onDestroyView();
  }
  @Override
  public void onRequestPermissionsResult(final int requestCode, @NonNull String[] permissions,
                                         @NonNull int[] grantResults) {
    PermissionUtils.requestPermissionsResult(getActivity(), requestCode, permissions, grantResults, mPermissionGrant);
  }
  /*private String getHostname() {
    final TextView editor = (TextView) rootView.findViewById(R.id.editor_hostname);

    return TextUtils.or(TextUtils.or(editor.getText(), editor.getHint()), "").toString().toLowerCase();
  }*/

  private void showError(String errString) {
    Snackbar.make(rootView, errString, Snackbar.LENGTH_LONG).show();
  }

  @Override
  public void showLoader() {
    //container.setVisibility(View.GONE);
    //waitingView.setVisibility(View.VISIBLE);
  }

  @Override
  public void hideLoader() {
    //waitingView.setVisibility(View.GONE);
    //container.setVisibility(View.VISIBLE);
  }

  @Override
  public void showInvalidServerError() {
    showError(getString(R.string.input_hostname_invalid_server_message));
  }

  @Override
  public void showConnectionError() {
    showError(getString(R.string.connection_error_try_later));
  }

  @Override
  public void showHome() {
      showMainHome();
  }
  protected void showMainHome(){

  }
}
