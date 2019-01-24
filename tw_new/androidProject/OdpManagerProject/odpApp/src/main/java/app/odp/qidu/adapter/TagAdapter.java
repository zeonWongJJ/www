package app.odp.qidu.adapter;

import android.content.Context;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.app.base.bean.UserRealm;
import com.app.base.flow.FlowTagLayout;
import com.app.base.flow.OnInitSelectedPosition;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;

/**
 * Created by HanHailong on 15/10/19.
 */
public class TagAdapter extends BaseAdapter implements OnInitSelectedPosition {
    private final Context mContext;
    private final List<UserRealm> mDataList = new ArrayList<>();
    private int tagModel;
    public static int COLOR_MODEL=3;//此参数代表给标签设置不同颜色
    public TagAdapter(Context context,int tagModel) {
        this.mContext = context;
        this.tagModel=tagModel;

    }

    @Override
    public int getCount() {
        return mDataList.size();
    }

    @Override
    public Object getItem(int position) {
        return mDataList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View view =null;
        if(tagModel== FlowTagLayout.FLOW_TAG_CHECKED_MULTI){
            view = LayoutInflater.from(mContext).inflate(R.layout.item_department_member, null);
        }else {
            view = LayoutInflater.from(mContext).inflate(R.layout.item_assemble_essay, null);
        }
        TextView textView = (TextView) view.findViewById(R.id.tv_tag);
        UserRealm t = mDataList.get(position);

        if(tagModel== FlowTagLayout.FLOW_TAG_CHECKED_MULTI){
            textView.setCompoundDrawablePadding(10);
            if(t.isSelect()){
                textView.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_checked,0,0,0);
            }else {
                textView.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_unchecked,0,0,0);
            }
            textView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    setSelectPosition(position);

                    if(selectClickListener!=null){
                        selectClickListener.onSelectItemClick(getSelectList());
                    }
                }
            });
        }else if(tagModel==COLOR_MODEL){
            textView.setTextColor(mContext.getResources().getColor(R.color.blue));
        }
        if(!TextUtils.isEmpty(t.getReal_name())){
            textView.setText(t.getReal_name());
        }else {
            textView.setText(t.getMember_name());
        }
        return view;
    }

    public List<UserRealm> getSelectList(){
        List<UserRealm> listSelect=new ArrayList<>();
        for(int i=0;i<mDataList.size();i++){
            if(mDataList.get(i).isSelect()){
                listSelect.add(mDataList.get(i));
            }
        }
        return listSelect;
    }
    public interface OnSelectClickListener{
        void onSelectItemClick(List<UserRealm> selectList);
    }
    private OnSelectClickListener selectClickListener;
    public void setOnSelectClickListener(OnSelectClickListener selectClickListener){
        this.selectClickListener=selectClickListener;
    }
    public List<UserRealm> getDataList(){
        return mDataList;
    }
    private void setSelectPosition(int position){
        if(!this.mDataList.get(position).isSelect()){
            this.mDataList.get(position).setSelect(true);
        }else {
            this.mDataList.get(position).setSelect(false);
        }
        this.notifyDataSetChanged();
    }

    public void setAllSelect(){
        if(mDataList!=null){
            for(int i=0;i<mDataList.size();i++){
                mDataList.get(i).setSelect(true);
            }
        }
        notifyDataSetChanged();
    }

    public void setAllunSelect(){
        for(int i=0;i<mDataList.size();i++){
            mDataList.get(i).setSelect(false);
        }
        notifyDataSetChanged();
    }
    public void onlyAddAll(List<UserRealm> datas) {
        mDataList.addAll(datas);
        notifyDataSetChanged();
    }

    public void clearAndAddAll(List<UserRealm> datas) {
        mDataList.clear();
        onlyAddAll(datas);
    }

    @Override
    public boolean isSelectedPosition(int position) {
        if (position % 2 == 0) {
            return true;
        }
        return false;
    }
}
