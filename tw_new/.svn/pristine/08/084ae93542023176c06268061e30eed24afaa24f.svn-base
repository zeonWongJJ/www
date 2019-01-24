package com.app.base.widget;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.drawable.Drawable;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import com.app.base.R;
import com.app.base.adapter.DialogPlanTypeAdapter;
import com.app.base.bean.TypeSelect;
import com.common.lib.utils.ToastUtils;

import java.util.ArrayList;
import java.util.List;


/**
 * 选择计划类型弹框
 */

public class PlanTypeSelectDialog extends Dialog {

    public PlanTypeSelectDialog(Context context) {
        super(context);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        this.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
    }

    @Override
    protected void onStart() {
        super.onStart();
        getWindow().setLayout(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
    }

    public static PlanTypeSelectDialog show(Context context, String title, List<TypeSelect> msg, String ok, String cancel, Drawable icon,
                                            final OnClickListener cancelListener, boolean cancelable) {
        final PlanTypeSelectDialog dialog = new PlanTypeSelectDialog(context);

        View view = initView(context, title, msg, ok, cancel, icon, cancelable, cancelListener, dialog);
        dialog.setOnCancelListener(new OnCancelListener() {
            @Override
            public void onCancel(DialogInterface dialog) {
                if (cancelListener != null) {
                    cancelListener.onDismiss();
                }
            }
        });
        dialog.setContentView(view);
        dialog.setCancelable(cancelable);
        dialog.show();
        return dialog;
    }

    public static PlanTypeSelectDialog show(Context context, String title, List<TypeSelect> msg, String ok, String cancel, int iconId,
                                            final OnClickListener cancelListener, boolean cancelable) {
        Drawable drawable = context.getResources().getDrawable(iconId);
        return show(context, title, msg, ok, cancel, drawable, cancelListener, cancelable);
    }

    public interface OnClickListener {
        public void onOkClick(TypeSelect data);

        public void onCancelClick();

        //public void onItemClick(TypeSelect data,int position);

        public void onDismiss();
    }


    private static View initView(Context context, String title, List<TypeSelect> msg, String ok, String cancel, Drawable icon, boolean cancelable,
                                 final OnClickListener clickListener, final Dialog dialog) {
        View rootView = LayoutInflater.from(context).inflate(R.layout.layout_plan_type_select_dialog, null);
        TextView tvTitle = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_title);
        ListView listView = (ListView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_msg);
        TextView tvPositive = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_positive);
        TextView tvNegative = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_negative);
        View top = rootView.findViewById(R.id.ll_m_view_app_dialog_p_title);
        //View dividerHorizontal = rootView.findViewById(R.id.view_m_view_app_dialog_p_divider_horizontal);
        //View dividerVertical = rootView.findViewById(R.id.view_m_view_app_dialog_p_divider_vertical);
        ImageView ivIcon = (ImageView) rootView.findViewById(R.id.iv_m_view_app_dialog_p_icon);
        DialogPlanTypeAdapter adapter=null;
        if (icon != null) {
            ivIcon.setImageDrawable(icon);
            top.setVisibility(View.VISIBLE);
        } else {
            ivIcon.setVisibility(View.GONE);
            LinearLayout.LayoutParams lp = (LinearLayout.LayoutParams) tvTitle.getLayoutParams();
            lp.width = LinearLayout.LayoutParams.WRAP_CONTENT;
            tvTitle.setLayoutParams(lp);
        }
        if (!TextUtils.isEmpty(title)) {
            tvTitle.setText(title);
            top.setVisibility(View.VISIBLE);
        }
        if (!msg.isEmpty()) {
            adapter=new DialogPlanTypeAdapter(listView,msg);
            listView.setAdapter(adapter);
            final DialogPlanTypeAdapter finalAdapter = adapter;
            listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                    finalAdapter.setSelectPosition(position);
                    /*if (clickListener != null) {
                        clickListener.onItemClick(adapter.getItem(position),position);
                    }
                    dialog.dismiss();*/
                }
            });
        } else {
            listView.setVisibility(View.GONE);
            //dividerHorizontal.setVisibility(View.GONE);
        }
        if (!TextUtils.isEmpty(ok)) {
            tvPositive.setText(ok);
        } else {
            tvPositive.setVisibility(View.GONE);
            //dividerVertical.setVisibility(View.INVISIBLE);

        }
        if (!TextUtils.isEmpty(cancel)) {
            tvNegative.setText(cancel);
        } else {
            tvNegative.setVisibility(View.GONE);
            //dividerVertical.setVisibility(View.INVISIBLE);
        }
        /*if (TextUtils.isEmpty(ok) && TextUtils.isEmpty(cancel)) {
            //dividerVertical.setVisibility(View.GONE);
            //dividerHorizontal.setVisibility(View.GONE);
        }*/
        final DialogPlanTypeAdapter finalAdapter = adapter;
        tvPositive.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (clickListener != null) {
                    if(finalAdapter!=null){
                        if(finalAdapter.getSelectPosition()!=-1){
                            clickListener.onOkClick(finalAdapter.getItem(finalAdapter.getSelectPosition()));
                            dialog.dismiss();
                        }else {
                            ToastUtils.show("请选择计划类型");
                        }
                    }
                }
            }
        });
        tvNegative.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (clickListener != null) {
                    clickListener.onCancelClick();
                }
                dialog.dismiss();
            }
        });

        return rootView;
    }

    public static class Builder {
        private Context context;
        private String title, ok, cancel;
        private boolean cancelable;
        private OnClickListener clickListener;
        private int iconId;
        private Drawable icon;

        private List<TypeSelect> msg;

        public Builder(Context context) {
            this.context = context;
            cancelable = true;
        }

        public Builder setTitle(String title) {
            this.title = title;
            return this;
        }

        public Builder setTitle(int titleId) {
            this.title = context.getResources().getString(titleId);
            return this;
        }

        public Builder setMsg(List<TypeSelect> msg) {
            this.msg = msg;
            return this;
        }


        public Builder setOk(String ok) {
            this.ok = ok;
            return this;
        }

        public Builder setCancel(String cancel) {
            this.cancel = cancel;
            return this;
        }

        public Builder setCancelable(boolean cancelable) {
            this.cancelable = cancelable;
            return this;
        }

        public Builder setClickListener(OnClickListener clickListener) {
            this.clickListener = clickListener;
            return this;
        }

        public Builder setIcon(Drawable icon) {
            this.icon = icon;
            return this;
        }

        public Builder setIconId(int iconId) {
            this.iconId = iconId;
            return this;
        }

        public PlanTypeSelectDialog create() {
            if (iconId != 0) {
                return PlanTypeSelectDialog.show(context, title, msg, ok, cancel, iconId, clickListener, cancelable);
            } else if (icon != null) {
                return PlanTypeSelectDialog.show(context, title, msg, ok, cancel, icon, clickListener, cancelable);
            } else {
                return PlanTypeSelectDialog.show(context, title, msg, ok, cancel, null, clickListener, cancelable);
            }
        }
    }


}
