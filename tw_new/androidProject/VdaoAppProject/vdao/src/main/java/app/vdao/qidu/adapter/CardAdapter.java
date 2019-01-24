package app.vdao.qidu.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.app.base.bean.Store;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.view.jameson.library.CardAdapterHelper;


import java.util.ArrayList;
import java.util.List;

import app.vdao.qidu.R;


/**
 * Created by jameson on 8/30/16.
 */
public class CardAdapter extends RecyclerView.Adapter<CardAdapter.ViewHolder> {
    private List<Store> mList = new ArrayList<>();
    private CardAdapterHelper mCardAdapterHelper = new CardAdapterHelper();
    private Context context;
    RequestOptions circleOptions = RequestOptions.circleCropTransform();

    public CardAdapter(Context context) {
        this.context = context;
    }

    public void refreshData(List<Store> mList){
        if(mList==null){
            mList=new ArrayList<>();
        }
        this.mList.clear();
        this.mList.addAll(mList);
        this.notifyDataSetChanged();
    }
    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(parent.getContext()).inflate(R.layout.layout_store_card_item, parent, false);
        mCardAdapterHelper.onCreateViewHolder(parent, itemView);
        return new ViewHolder(itemView);
    }

    @Override
    public void onBindViewHolder(final ViewHolder holder, final int position) {
        //Log.i("aaaaaaa",position+"==========mList.size()===="+mList.size());
        mCardAdapterHelper.onBindViewHolder(holder.itemView, position,mList.size());

        Store store=mList.get(position);
        holder.storeName.setText( store.getStore_name());
        int distance=(int)(store.getDistance());
        if(distance<1000){
            holder.distance.setText( distance+"m");
        }else {
            float  b   =  (float)(Math.round(distance/1000*100))/100;
            holder.distance.setText(b+"km");
        }

        //holder.setText(R.id.store_introduction, store.getStore_introduction());
        holder.address.setText( store.getStore_address());
        Glide.with(context).load(store.getMain_pic()).into(holder.storeImg);
        /*if(store.getMain_pic()!=null){
            //String url=BaseApiService.Base_URL+store.getStore_img();
            Glide.with(context).load(store.getMain_pic()).into(holder.storeImg);
        }*/
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(mItemClickListener!=null){
                    mItemClickListener.onItemClick(position,v);
                }
            }
        });
        if(store.getComment_total()>100){
            holder.commentTotal.setText(store.getComment_total()+"+");
        }else {
            holder.commentTotal.setText("" + store.getComment_total());
        }

        /*if(holder.userList.getChildCount()>5){
            for (int i=5;i<holder.userList.getChildCount();i++){

                holder.userList.removeViewAt(i);
            }
        }*/
        /*int userNum=3;
        List<String> userList=store.getUserpic_arr();
        if(!userList.isEmpty()) {
            for (int i = 0; i < holder.userList.getChildCount() && i < userList.size(); i++) {
                ImageView iconUser = (ImageView) holder.userList.getChildAt(i);
                if (i < userNum) {
                    iconUser.setVisibility(View.VISIBLE);
                    Glide.with(context).load(userList.get(i)).apply(circleOptions).into(iconUser);
                } else {
                    iconUser.setVisibility(View.INVISIBLE);
                }
            }
        }else {
            for (int i = 0; i < holder.userList.getChildCount(); i++) {
                ImageView iconUser = (ImageView) holder.userList.getChildAt(i);
                iconUser.setVisibility(View.INVISIBLE);
            }
        }*/
    }
    public List<Store> getDataList(){
        return mList;
    }
    protected OnItemClickListener mItemClickListener;

    public interface OnItemClickListener {
        void onItemClick(int position, View v);
    }

    public void setOnItemClickListener(OnItemClickListener listener) {
        this.mItemClickListener = listener;
    }
    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        public final ImageView storeImg;
        public final TextView storeName,distance,address,commentTotal;
        //public final LinearLayout userList;
        public ViewHolder(final View itemView) {
            super(itemView);
            storeImg = (ImageView) itemView.findViewById(R.id.store_license);
            storeName=itemView.findViewById(R.id.store_name);
            distance=itemView.findViewById(R.id.distance);
            address=itemView.findViewById(R.id.store_address);
            //userList=itemView.findViewById(R.id.user_list);
            commentTotal=itemView.findViewById(R.id.comment_total);
        }

    }

}
