package com.qidu.chat.fragment.chatroom.dialog;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.app.AppCompatDialogFragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.hadisatrio.optional.Optional;
import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.R;
import com.qidu.chat.commen.OnPasswordInputFinish;
import com.qidu.chat.fragment.SendRedPacketDialogFragment;
import com.qidu.chat.fragment.chatroom.RocketChatAbsoluteUrl;
import com.qidu.chat.helper.AbsoluteUrlHelper;
import com.qidu.chat.helper.LogIfError;
import com.qidu.chat.helper.Logger;
import com.qidu.chat.layouthelper.chatroom.dialog.RoomUserAdapter;
import com.qidu.chat.service.ConnectivityManager;
import com.qidu.chat.widget.PasswordView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

import chat.rocket.android.log.RCLog;
import chat.rocket.core.SyncState;
import chat.rocket.core.interactors.SessionInteractor;
import chat.rocket.persistence.realm.RealmObjectObserver;
import chat.rocket.persistence.realm.models.internal.GetUsersOfRoomsProcedure;
import chat.rocket.persistence.realm.repositories.RealmServerInfoRepository;
import chat.rocket.persistence.realm.repositories.RealmSessionRepository;
import chat.rocket.persistence.realm.repositories.RealmUserRepository;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;

/**
 * 红包支付界面
 */
public class RedPacketPayDialogFragment extends AppCompatDialogFragment {
    private View rootView;
  private String hostname;
    private PasswordView pwdView;

  public RedPacketPayDialogFragment() {
  }

  /**
   * create UsersOfRoomDialogFragment with required parameters.
   */
  public static RedPacketPayDialogFragment create(String roomId, String hostname) {
    Bundle args = new Bundle();
    args.putString("hostname", hostname);
    args.putString("roomId", roomId);

    RedPacketPayDialogFragment fragment = new RedPacketPayDialogFragment();
    fragment.setArguments(args);

    return fragment;
  }

  @Override
  public void onCreate(@Nullable Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    setStyle(AppCompatDialogFragment.STYLE_NORMAL, android.R.style.Theme_Black_NoTitleBar);

  }


  /*@Override
  protected void handleArgs(@NonNull Bundle args) {
    super.handleArgs(args);
    hostname = args.getString("hostname");
  }*/
  @Nullable
  @Override
  public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
      rootView=inflater.inflate(R.layout.dialog_red_packet_pay_room,container,false);
      return rootView;
  }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        onSetupView();
    }


  protected void onSetupView() {
      pwdView = (PasswordView) rootView.findViewById(R.id.pwd_view);
      //添加密码输入完成的响应
      pwdView.setOnFinishInput(new OnPasswordInputFinish() {
          @Override
          public void inputFinish(final String password) {
              Toast.makeText(getActivity(), "支付成功，密码为：" + password, Toast.LENGTH_SHORT).show();
          }
      });

      // 监听X关闭按钮
      pwdView.getImgCancel().setOnClickListener(new View.OnClickListener() {
          @Override
          public void onClick(View v) {
              dismiss();
          }
      });

      // 监听键盘上方的返回
      pwdView.getVirtualKeyboardView().getLayoutBack().setOnClickListener(new View.OnClickListener() {
          @Override
          public void onClick(View v) {
              dismiss();
          }
      });
  }



    private void callbackOnHandle(String message) {
        final Fragment fragment = getTargetFragment();
        if (fragment instanceof RedPacketPayDialogFragment.SendRedPacketCallback) {
            ((RedPacketPayDialogFragment.SendRedPacketCallback) fragment).onSuccessCallBack(message);
        }
    }

    public interface SendRedPacketCallback {
        void onSuccessCallBack(String message);
    }
}
