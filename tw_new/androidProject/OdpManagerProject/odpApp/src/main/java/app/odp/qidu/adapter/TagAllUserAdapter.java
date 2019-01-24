package app.odp.qidu.adapter;

import android.content.Context;
import android.text.TextUtils;
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
 *发布公告通知选择人员
 */
public class TagAllUserAdapter extends BaseAdapter implements OnInitSelectedPosition {
    private final Context mContext;
    private final List<UserRealm> mDataList;
    public TagAllUserAdapter(Context context) {
        this.mContext = context;
        mDataList = new ArrayList<>();
    }

    @Override
    public int getCount() {
        return mDataList.size()+1;
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
        View view = LayoutInflater.from(mContext).inflate(R.layout.item_department_member, null);
        TextView textView = (TextView) view.findViewById(R.id.tv_tag);
        textView.setCompoundDrawablePadding(10);
        if(position==0){
            int size=getSelectList().size();
            if(size==mDataList.size()){
                textView.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_checked, 0, 0, 0);
            }else {
                textView.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_unchecked, 0, 0, 0);
            }
            textView.setText("全选");
            textView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    int size=getSelectList().size();
                    if(size==mDataList.size()){//已经全选，设置全不选
                        for(int i=0;i<mDataList.size();i++){
                            mDataList.get(i).setSelect(false);
                        }
                        notifyDataSetChanged();
                    }else {
                        for(int i=0;i<mDataList.size();i++){
                            mDataList.get(i).setSelect(true);
                        }
                        notifyDataSetChanged();
                    }
                }
            });
        }else {
            UserRealm t = mDataList.get(position-1);
            if (t.isSelect()) {
                textView.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_checked, 0, 0, 0);
            } else {
                textView.setCompoundDrawablesWithIntrinsicBounds(R.drawable.icon_circle_unchecked, 0, 0, 0);
            }
            textView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    setSelectPosition(position-1);
                    if (selectClickListener != null) {
                        selectClickListener.onSelectItemClick(getSelectList());
                    }
                }
            });
            if (t.getReal_name()!=null) {
                textView.setText(t.getReal_name());
            } else {
                textView.setText(t.getMember_name());
            }
        }
        return view;
    }
    //设置默认选中的人
    public void setSelectUser(List<UserRealm> listSelect){
        for(int i=0;i<mDataList.size();i++){
            for(int k=0;k<listSelect.size();k++){
                if(mDataList.get(i).getMember_id().equals(listSelect.get(k).getMember_id())){
                    mDataList.get(i).setSelect(true);
                }
            }
        }
        notifyDataSetChanged();
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
