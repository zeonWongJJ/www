package com.qidu.chat.fragment;

import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.DialogFragment;
import android.support.v4.app.Fragment;
import android.support.v7.app.AppCompatDialogFragment;
import android.text.Editable;
import android.text.Selection;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.hadisatrio.optional.Optional;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.qidu.chat.BackgroundLooper;
import com.qidu.chat.R;
import com.qidu.chat.fragment.chatroom.RoomFragment;
import com.qidu.chat.fragment.chatroom.dialog.RedPacketPayDialogFragment;
import com.qidu.chat.helper.KeyboardHelper;
import com.qidu.chat.helper.LogIfError;
import com.qidu.chat.service.ConnectivityManager;

import java.util.ArrayList;

import chat.rocket.android.log.RCLog;
import chat.rocket.core.SyncState;
import chat.rocket.core.models.Room;
import chat.rocket.core.models.User;
import chat.rocket.core.utils.CommonKey;
import chat.rocket.persistence.realm.RealmHelper;
import chat.rocket.persistence.realm.RealmObjectObserver;
import chat.rocket.persistence.realm.RealmStore;
import chat.rocket.persistence.realm.models.internal.GetUsersOfRoomsProcedure;
import chat.rocket.persistence.realm.repositories.RealmUserRepository;
import io.reactivex.Single;
import io.reactivex.SingleSource;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Function;

import static android.content.Context.MODE_PRIVATE;

/**
 * 发红包
 */

public class SendRedPacketDialogFragment extends AppCompatDialogFragment implements View.OnClickListener{
    private View rootView,closeBtn,groupSendLayout,singleSendLayout,numRedPacketLayout;
    private String params;
    ProgressDialog dialog;
    private Button sendButton;
    private boolean isGroupSend=false;//单发还是群发
    private EditText redPacketNum,redPacketMoneyTotal,redPacketMoneySimple,remarks;
    private TextView totalMoney,tipMessage,members;
    private String sendParams;
    private String roomId;
    public static SendRedPacketDialogFragment create(
            String actionItems,String hostname,String roomId) {
        SendRedPacketDialogFragment fragment = new SendRedPacketDialogFragment();
        fragment.setParams(actionItems,hostname,roomId);

        return fragment;
    }

    private RealmObjectObserver<GetUsersOfRoomsProcedure> procedureObserver;
    protected RealmHelper realmHelper;


    private String hostname;
    public void setParams(String params,String hostname,String roomId) {
        this.params = params;
        this.hostname=hostname;
        this.roomId=roomId;
    }
    private BroadcastReceiver broadcastReceiver=new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            String action=intent.getAction();
            String isSuccess=intent.getStringExtra("successState");
            if(dialog!=null){
                dialog.dismiss();
            }
            if(action==null){
                return;
            }
            if(action.equals(CommonKey.KEY_SEND_RED_PACKET_SUCCESS_STATE)){
                if(isSuccess.equals("success")){
                    dismiss();
                }else if(isSuccess.equals("failure")){
                    Toast.makeText(getActivity(),"发送失败,请重试",Toast.LENGTH_SHORT).show();
                }
            }
        }
    };
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setStyle(AppCompatDialogFragment.STYLE_NORMAL, android.R.style.Theme_Black_NoTitleBar);

        IntentFilter filter = new IntentFilter();
        filter.addAction(CommonKey.KEY_SEND_RED_PACKET_SUCCESS_STATE);
        getActivity().registerReceiver(broadcastReceiver,filter);
        if(this.params.equals(Room.TYPE_DIRECT_MESSAGE)){//单发
            isGroupSend=false;
        }else if(this.params.equals(Room.TYPE_CHANNEL)){
            isGroupSend=true;

            realmHelper = RealmStore.get(hostname);
            procedureObserver = realmHelper
                    .createObjectObserver(realm ->
                            realm.where(GetUsersOfRoomsProcedure.class).equalTo("roomId", roomId))
                    .setOnUpdateListener(this::onUpdateGetUsersOfRoomProcedure);
            //previousSyncState = SyncState.NOT_SYNCED;

            if (savedInstanceState == null) {
                requestGetUsersOfRoom();
            }
        }

    }
    private void requestGetUsersOfRoom() {
        realmHelper.executeTransaction(realm -> {
            realm.createOrUpdateObjectFromJson(GetUsersOfRoomsProcedure.class, new JSONObject()
                    .put("roomId", roomId)
                    .put("syncstate", SyncState.NOT_SYNCED)
                    .put("showAll", true));
            return null;
        }).onSuccessTask(task -> {
            ConnectivityManager.getInstance(getContext().getApplicationContext())
                    .keepAliveServer();
            return task;
        }).continueWith(new LogIfError());
    }
    private void onUpdateGetUsersOfRoomProcedure(GetUsersOfRoomsProcedure procedure) {
        if (procedure == null) {
            return;
        }
        int syncState = procedure.getSyncState();
        /*if (previousSyncState != syncState) {
            onSyncStateUpdated(syncState);
            previousSyncState = syncState;
        }*/

        if (syncState == SyncState.SYNCED) {
            if(members!=null){
                members.setText("本群共"+procedure.getTotal()+"人");
            }
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        if(isGroupSend){
            procedureObserver.sub();
        }
    }

    @Override
    public void onPause() {
        if(isGroupSend){
            procedureObserver.unsub();
        }
        super.onPause();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        getActivity().unregisterReceiver(broadcastReceiver);
    }

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        rootView=inflater.inflate(R.layout.fragment_send_red_packet_dialog,container,false);
        return rootView;
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        /*if(this.params.equals(Room.TYPE_DIRECT_MESSAGE)){//单发
            isGroupSend=false;
        }else if(this.params.equals(Room.TYPE_CHANNEL)){
            isGroupSend=true;
        }*/
        tipMessage=rootView.findViewById(R.id.tip_message);
        numRedPacketLayout=rootView.findViewById(R.id.num_red_packet_layout);
        singleSendLayout=rootView.findViewById(R.id.single_send_layout);
        groupSendLayout=rootView.findViewById(R.id.group_send_layout);
        redPacketNum=rootView.findViewById(R.id.red_packet_num);
        redPacketMoneyTotal=rootView.findViewById(R.id.red_packet_money_total);
        redPacketMoneySimple=rootView.findViewById(R.id.red_packet_money_simple);
        remarks=rootView.findViewById(R.id.remarks);
        totalMoney=rootView.findViewById(R.id.total_money);
        closeBtn=rootView.findViewById(R.id.details_popview_close_img);
        sendButton=rootView.findViewById(R.id.send_button);
        members=rootView.findViewById(R.id.members);
        sendButton.setOnClickListener(this);
        closeBtn.setOnClickListener(this);
        if(!isGroupSend){//单发
            numRedPacketLayout.setVisibility(View.GONE);
            groupSendLayout.setVisibility(View.GONE);
            singleSendLayout.setVisibility(View.VISIBLE);
            redPacketMoneySimple.setVisibility(View.VISIBLE);
            groupSendLayout.setVisibility(View.GONE);
        }else {
            numRedPacketLayout.setVisibility(View.VISIBLE);
            groupSendLayout.setVisibility(View.VISIBLE);
            singleSendLayout.setVisibility(View.GONE);
            groupSendLayout.setVisibility(View.VISIBLE);
            redPacketMoneySimple.setVisibility(View.GONE);
        }
        redPacketNum.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence s, int i, int i1, int i2) {
                if(s == null || s.length() == 0){
                    sendButton.setEnabled(false);
                    return;
                }
                Editable editable = redPacketNum.getText();
                int maxLen=3;
                int len = editable.length();
                int num=Integer.parseInt(redPacketNum.getEditableText().toString());
                if(len > maxLen&&num>100){
                    int selEndIndex = Selection.getSelectionEnd(editable);
                    String str = editable.toString();
                    //截取新字符串
                    String newStr = str.substring(0,maxLen);
                    redPacketNum.setText(newStr);
                    editable = redPacketNum.getText();

                    //新字符串的长度
                    int newLen = editable.length();
                    //旧光标位置超过字符串长度
                    if(selEndIndex > newLen){
                        selEndIndex = editable.length();
                    }
                    //设置新光标所在的位置
                    Selection.setSelection(editable, selEndIndex);
                }
                if(num>100){
                    tipMessage.setVisibility(View.VISIBLE);
                    tipMessage.setText("红包个数不能超过100个");
                    sendButton.setEnabled(false);
                }else {
                    tipMessage.setVisibility(View.GONE);
                    //sendButton.setEnabled(false);
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });
        remarks.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                Editable editable = remarks.getText();
                int maxLen=15;
                int len = editable.length();
                if(len > maxLen){
                    int selEndIndex = Selection.getSelectionEnd(editable);
                    String str = editable.toString();
                    //截取新字符串
                    String newStr = str.substring(0,maxLen);
                    remarks.setText(newStr);
                    editable = remarks.getText();

                    //新字符串的长度
                    int newLen = editable.length();
                    //旧光标位置超过字符串长度
                    if(selEndIndex > newLen){
                        selEndIndex = editable.length();
                    }
                    //设置新光标所在的位置
                    Selection.setSelection(editable, selEndIndex);
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });
        redPacketMoneyTotal.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {

                if(s == null || s.length() == 0){
                    //totalMoney.setText("0.00");
                    sendButton.setEnabled(false);
                    return;
                }
                if (s.toString().contains(".")) {
                    if (s.length() - 1 - s.toString().indexOf(".") > 2) {
                        s = s.toString().subSequence(0,
                                s.toString().indexOf(".") + 3);
                        redPacketMoneyTotal.setText(s);
                        redPacketMoneyTotal.setSelection(s.length());
                    }
                }
                if (s.toString().trim().substring(0).equals(".")) {
                    s = "0" + s;
                    redPacketMoneyTotal.setText(s);
                    redPacketMoneyTotal.setSelection(2);
                }

                if (s.toString().startsWith("0")
                        && s.toString().trim().length() > 1) {
                    if (!s.toString().substring(1, 2).equals(".")) {
                        redPacketMoneyTotal.setText(s.subSequence(0, 1));
                        redPacketMoneyTotal.setSelection(1);
                        sendButton.setEnabled(false);
                        return;
                    }
                }

                if(s.toString().trim().substring(0,1).equals(".") || s.toString().trim().substring(s.toString().trim().length()-1,s.toString().trim().length()).equals(".")){
                    sendButton.setEnabled(false);
                    return;
                }
                /*judgeNumber(redPacketMoneyTotal.getEditableText());*/
                String temp = redPacketMoneyTotal.getEditableText().toString();
                int posDot = temp.indexOf(".");//返回指定字符在此字符串中第一次出现处的索引
                if (posDot <= 0) {//不包含小数点
                    if (temp.length() > 5) {
                        redPacketMoneyTotal.getEditableText().delete(5, 6);//大于五位数就删掉第六位（只会保留五位）
                    }
                }else if(temp.length() - posDot - 1 > 2)//如果包含小数点
                {
                    redPacketMoneyTotal.getEditableText().delete(posDot + 3, posDot + 4);//删除小数点后的第三位
                }

                String money=redPacketMoneyTotal.getText().toString();
                totalMoney.setText(money);
                if(Float.parseFloat(money)>200&&!isGroupSend){//单个
                    tipMessage.setVisibility(View.VISIBLE);
                    tipMessage.setText("单个红包金额不可超过200");
                    sendButton.setEnabled(false);
                }else if(Float.parseFloat(money)>2000&&isGroupSend){
                    tipMessage.setVisibility(View.VISIBLE);
                    tipMessage.setText("单次支付总额不可超过2000");
                    sendButton.setEnabled(false);
                }else {
                    tipMessage.setVisibility(View.GONE);
                    sendButton.setEnabled(true);
                }

            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });
        redPacketMoneySimple.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
//优惠券必须要达到的金额Integer.parseInt(fullPrice);
                if(s == null || s.length() == 0){
                    //totalMoney.setText("0.00");
                    sendButton.setEnabled(false);
                    return;
                }
                if (s.toString().contains(".")) {
                    if (s.length() - 1 - s.toString().indexOf(".") > 2) {
                        s = s.toString().subSequence(0,
                                s.toString().indexOf(".") + 3);
                        redPacketMoneySimple.setText(s);
                        redPacketMoneySimple.setSelection(s.length());
                    }
                }
                if (s.toString().trim().substring(0).equals(".")) {
                    s = "0" + s;
                    redPacketMoneySimple.setText(s);
                    redPacketMoneySimple.setSelection(2);
                }

                if (s.toString().startsWith("0")
                        && s.toString().trim().length() > 1) {
                    if (!s.toString().substring(1, 2).equals(".")) {
                        redPacketMoneySimple.setText(s.subSequence(0, 1));
                        redPacketMoneySimple.setSelection(1);
                        sendButton.setEnabled(false);
                        return;
                    }
                }

                if(s.toString().trim().substring(0,1).equals(".") || s.toString().trim().substring(s.toString().trim().length()-1,s.toString().trim().length()).equals(".")){
                    sendButton.setEnabled(false);
                    return;
                }
                String temp = redPacketMoneySimple.getEditableText().toString();
                int posDot = temp.indexOf(".");//返回指定字符在此字符串中第一次出现处的索引
                if (posDot <= 0) {//不包含小数点
                    if (temp.length() > 5) {
                        redPacketMoneySimple.getEditableText().delete(5, 6);//大于五位数就删掉第六位（只会保留五位）
                    }
                }else if (temp.length() - posDot - 1 > 2)//如果包含小数点
                {
                    redPacketMoneySimple.getEditableText().delete(posDot + 3, posDot + 4);//删除小数点后的第三位
                }

                String money=redPacketMoneySimple.getText().toString();
                totalMoney.setText(money);
                if(Float.parseFloat(money)>200&&!isGroupSend){//单个
                    tipMessage.setVisibility(View.VISIBLE);
                    tipMessage.setText("单个红包金额不可超过200");
                    sendButton.setEnabled(false);
                }/*else if(Float.parseFloat(money)>2000&&isGroupSend){
                    tipMessage.setVisibility(View.VISIBLE);
                    tipMessage.setText("单次支付总额不可超过2000");
                    sendButton.setEnabled(false);
                }*/else {
                    tipMessage.setVisibility(View.GONE);
                    sendButton.setEnabled(true);
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });
    }
    /**
     * 金额输入框中的内容限制（最大：小数点前五位，小数点后2位）
     * @param edt
     */
    public void judgeNumber(Editable edt){


    }
    @Override
    public void onClick(View view) {
        int i = view.getId();
        if (i == R.id.details_popview_close_img) {
            this.dismiss();
            SharedPreferences pref = getActivity().getSharedPreferences("sendRedPacketFlag", MODE_PRIVATE);
            SharedPreferences.Editor editor = pref.edit();
            editor.putString("sendRedPacketFlag", null);
            editor.commit();


        } else if (i == R.id.send_button) {/*
                * $FHB$ 20$repacketNum 10$
                * */
            KeyboardHelper.hideSoftKeyboard(getActivity());
            if (checkedParams()) {
                dialog = ProgressDialog.show(getActivity(), "提示", "发送中", false, true);
                    /*if(isGroupSend){
                        sendParams="bot:FHB: "+totalMoney.getText().toString()+" :redPacketNum "+redPacketNum.getText().toString()+":receiveState "+"no"+":remarks "+remarks.getText().toString();
                    }else {
                        sendParams="bot:FHB: "+totalMoney.getText().toString()+" :redPacketNum 1"+":receiveState "+"no"+":remarks "+remarks.getText().toString();
                    }*/
                //sendParams="bot :FHB: 20 :redPacketNum 1:receiveState no:remarks 恭喜发财，大吉大利";
                Disposable subscription = getCurrentUser().flatMap(new Function<User, SingleSource<?>>() {
                    @Override
                    public SingleSource<?> apply(@NonNull User user) throws Exception {
                        JSONObject object = new JSONObject();
                        object.put("money", totalMoney.getText().toString());
                        object.put("receiveState", "no");//no表示没给抢过的初始状态
                        String strRemarks = remarks.getText().toString();
                        if (strRemarks.isEmpty()) {
                            strRemarks = "恭喜发财,大吉大利";
                        }
                        object.put("remarks", strRemarks);
                        object.put("timeTemp", System.currentTimeMillis());
                        object.put("userId", user.getId());
                        object.put("userName", user.getUsername());
                        object.put("redPacketId", user.getId() + System.currentTimeMillis());//模拟红包id
                        if (isGroupSend) {
                            object.put("redPacketNum", redPacketNum.getText().toString());
                        } else {
                            object.put("redPacketNum", "1");
                        }
                        sendParams = "bot:FHB:" + object.toString();
                        //callbackOnHandle(sendParams);

                        /*final RedPacketPayDialogFragment fragment = RedPacketPayDialogFragment
                                .create(roomId,hostname);
                        fragment.setTargetFragment(SendRedPacketDialogFragment.this, 0x123);*/
                        RedPacketPayDialogFragment
                                .create(roomId,hostname).show(getFragmentManager(), "RedPacketPayDialogFragment");
                        return Single.just(user);
                    }
                }).subscribeOn(AndroidSchedulers.from(BackgroundLooper.get()))
                        .observeOn(AndroidSchedulers.mainThread())
                        .subscribe();
            }


        }

    }
    private Single<User> getCurrentUser() {
        RealmUserRepository userRepository = new RealmUserRepository(hostname);
        return userRepository.getCurrent()
                .filter(Optional::isPresent)
                .map(Optional::get)
                .firstElement()
                .toSingle();
    }
    private boolean checkedParams(){
        if(isGroupSend){
            if(TextUtils.isEmpty(redPacketNum.getText().toString())){
                Toast.makeText(getActivity(),"请输入红包个数",Toast.LENGTH_SHORT).show();
                return false;
            }
            if(TextUtils.isEmpty(redPacketMoneyTotal.getText().toString())){
                Toast.makeText(getActivity(),"请输入红包金额",Toast.LENGTH_SHORT).show();
                return false;
            }
        }else {
            if(TextUtils.isEmpty(redPacketMoneySimple.getText().toString())){
                Toast.makeText(getActivity(),"请输入红包金额",Toast.LENGTH_SHORT).show();
                return false;
            }
        }

        return true;
    }

    private void callbackOnHandle(String message) {
        final Fragment fragment = getTargetFragment();
        if (fragment instanceof SendRedPacketCallback) {
            ((SendRedPacketCallback) fragment).onSuccessCallBack(message);
        }
    }

    public interface SendRedPacketCallback {
        void onSuccessCallBack(String message);
    }
}
