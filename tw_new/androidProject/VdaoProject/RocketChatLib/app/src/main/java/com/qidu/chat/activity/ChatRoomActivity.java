package com.qidu.chat.activity;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.FragmentActivity;

import com.qidu.chat.fragment.chatroom.RoomFragment;

import com.qidu.chat.R;

import com.qidu.chat.helper.KeyboardHelper;

/**
 * Created by 7du-28 on 2017/10/10.
 */

public class ChatRoomActivity extends FragmentActivity{


    protected int getLayoutContainerForFragment() {
        return R.id.activity_main_container;
    }
    private String hostname,roomId;
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat_room);
        hostname=getIntent().getStringExtra("hostname");
        roomId=getIntent().getStringExtra("roomId");
        if(hostname!=null&&roomId!=null){
            getSupportFragmentManager().beginTransaction()
                    .replace(getLayoutContainerForFragment(), RoomFragment.create(hostname, roomId))
                    .commit();
            KeyboardHelper.hideSoftKeyboard(this);
        }

    }

}
