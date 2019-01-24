package app.odp.qidu.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.app.base.bean.Comment;
import com.app.base.bean.StructureBean;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;

/**
 * 项目下的子项目列表
 */

public class ChildrenProjectListAdapter extends
        RecyclerView.Adapter<ChildrenProjectListAdapter.ViewHolder> {
    public final int TYPE_ADD = 1;
    public final int TYPE_DEFAULT = 2;
    private LayoutInflater mInflater;
    private Context mContext;
    private List<StructureBean> list=new ArrayList<>();

    /**
     * 点击添加图片跳转
     */
    private onAddClickListener mOnAddPicClickListener;

    public interface onAddClickListener {
        void onAddPicClick(int type, int position);
    }
    //paddingSpace是recyclerview左右距离屏幕的距离
    public ChildrenProjectListAdapter(Context context, onAddClickListener mOnAddPicClickListener) {
        this.mContext=context;
        mInflater = LayoutInflater.from(context);
        this.mOnAddPicClickListener = mOnAddPicClickListener;
    }
    public void addNewStructure(StructureBean structureBean){//预处理，添加一条新评论在第一条
        list.add(structureBean);
        notifyDataSetChanged();
        //notifyItemRangeInserted(list.size()-1,list.size());
    }

    public void removeStructure(String structure_id){//预处理，添加一条新评论在第一条
        if(list.size()>0){
            for(int i=0;i<list.size();i++){
                if(structure_id.equals(list.get(i).getStructure_id())){
                    list.remove(i);
                    notifyItemRemoved(i);
                }
            }
        }
        //notifyItemRangeInserted(list.size()-1,list.size());
    }

    public void setList(List<StructureBean> list) {
        this.list = list;
    }
    public List<StructureBean> getDataList(){
        return list;
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView title;
        public ViewHolder(View view) {
            super(view);
            title=view.findViewById(R.id.project_name);
        }
    }

    @Override
    public int getItemCount() {
        return list.size() + 1;
    }

    @Override
    public int getItemViewType(int position) {
        if (isShowAddItem(position)) {
            return TYPE_ADD;
        } else {
            return TYPE_DEFAULT;
        }
    }

    /**
     * 创建ViewHolder
     */
    @Override
    public ViewHolder onCreateViewHolder(ViewGroup viewGroup, int i) {
        View view = mInflater.inflate(R.layout.layout_children_project_list_item,
                viewGroup, false);
        /*Log.i("bbbbbbbb","getItemViewType------->"+getItemViewType(i));
        if (getItemViewType(i) == TYPE_ADD) {
            view = mInflater.inflate(R.layout.layout_children_project_add_item,
                    viewGroup, false);
        }else if(getItemViewType(i) == TYPE_DEFAULT){
            view = mInflater.inflate(R.layout.layout_children_project_list_item,
                    viewGroup, false);
        }*/
        final ViewHolder viewHolder = new ViewHolder(view);
        //itemView 的点击事件
        if (mItemClickListener != null) {
            viewHolder.itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    mItemClickListener.onItemClick(viewHolder.getAdapterPosition(), v);
                }
            });
        }
        return viewHolder;
    }

    private boolean isShowAddItem(int position) {
        if(list.size() == 0||position==list.size()){
            return true;
        }
        return false;
    }

    /**
     * 设置值
     */
    @Override
    public void onBindViewHolder(final ViewHolder viewHolder, final int position) {
        if (getItemViewType(position) == TYPE_ADD) {
            viewHolder.title.setTextColor(mContext.getResources().getColor(R.color.red_text));
            viewHolder.title.setGravity(Gravity.CENTER);
            viewHolder.title.setText("+ 添加子项目");
            viewHolder.title.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    mOnAddPicClickListener.onAddPicClick(0, viewHolder.getAdapterPosition());
                }
            });
        }else {
            StructureBean data=list.get(position);
            viewHolder.title.setTextColor(mContext.getResources().getColor(R.color.black));
            viewHolder.title.setGravity(Gravity.LEFT|Gravity.CENTER_VERTICAL);
            viewHolder.title.setText(data.getStructure_name());
        }
        //viewHolder.title
    }

    protected OnItemClickListener mItemClickListener;

    public interface OnItemClickListener {
        void onItemClick(int position, View v);
    }

    public void setOnItemClickListener(OnItemClickListener listener) {
        this.mItemClickListener = listener;
    }
}
