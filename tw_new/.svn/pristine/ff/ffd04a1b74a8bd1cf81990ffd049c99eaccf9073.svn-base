package com.printer.receipt.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

import cashier.vdao.app.R;

/**
 * 热敏干胶机USB列表选择
 */

public class HotPaperAdapter extends BaseAdapter{


    private Context context;

    public HotPaperAdapter(Context context) {
        this.context = context;
    }

    public void refreshData(List<String> list){
        this.list.clear();
        this.list=list;
        this.notifyDataSetChanged();
    }
    private List<String> list=new ArrayList<String>();
    @Override
    public int getCount() {
        return list.size();
    }

    @Override
    public String getItem(int i) {
        if(list.size()==0){
            return null;
        }
        return list.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        String usbDevice= (String) getItem(i);
         ViewHolder viewHolder=null;
        if(view == null){
            view = View.inflate(context, R.layout.layout_usb_device_item,null);
            viewHolder = new ViewHolder();
            viewHolder.textView = (TextView) view.findViewById(R.id.textview);
            view.setTag(viewHolder);
        }else{
            viewHolder = (ViewHolder) view.getTag();
        }
        if(usbDevice!=null){
            viewHolder.textView.setText(usbDevice);
        }
        return view;
    }

    public class ViewHolder{
        TextView textView;
    }
}
