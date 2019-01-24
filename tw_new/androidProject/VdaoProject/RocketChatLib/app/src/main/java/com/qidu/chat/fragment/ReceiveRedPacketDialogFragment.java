package com.qidu.chat.fragment;

import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatDialogFragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import com.qidu.chat.R;
import com.qidu.chat.adapter.RedPacketListAdapter;

/**
 * 展示红包详情结果
 */

public class ReceiveRedPacketDialogFragment extends AppCompatDialogFragment implements View.OnClickListener{
    private View rootView,closeBtn,headerView;
    private String params;
    private ListView listView;
    private RedPacketListAdapter adapter;

    public static ReceiveRedPacketDialogFragment create(
            String actionItems) {
        ReceiveRedPacketDialogFragment fragment = new ReceiveRedPacketDialogFragment();
        fragment.setParams(actionItems);

        return fragment;
    }
    public void setParams(String params) {
        this.params = params;
    }
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setStyle(AppCompatDialogFragment.STYLE_NORMAL, android.R.style.Theme_Black_NoTitleBar);
    }
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        rootView=inflater.inflate(R.layout.fragment_receive_red_packet_dialog,container,false);
        return rootView;
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        headerView=getActivity().getLayoutInflater().inflate(R.layout.layout_red_packet_header,null);
        closeBtn=rootView.findViewById(R.id.details_popview_close_img);
        listView=rootView.findViewById(R.id.red_packet_list);
        listView.setDivider(new ColorDrawable(Color.GRAY));
        listView.setDividerHeight(1);
        listView.addHeaderView(headerView);
        closeBtn.setOnClickListener(this);
        adapter=new RedPacketListAdapter(listView,null);
        listView.setAdapter(adapter);
    }

    @Override
    public void onClick(View view) {
        int i = view.getId();
        if (i == R.id.details_popview_close_img) {
            this.dismiss();

        }

    }

}
