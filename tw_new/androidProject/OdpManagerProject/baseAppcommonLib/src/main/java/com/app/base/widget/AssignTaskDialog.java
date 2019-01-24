package com.app.base.widget;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.drawable.Drawable;
import android.text.TextUtils;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import com.app.base.R;
import com.app.base.adapter.DialogAssignTaskAdapter;
import com.app.base.bean.UserRealm;
import com.common.lib.utils.ScreenUtils;

import java.util.List;


/**
 * 指派任务弹框
 */

public class AssignTaskDialog extends Dialog {
    private AssignTaskDialog(Context context) {
        super(context);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        this.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
    }
    @Override
    protected void onStart() {
        super.onStart();
        getWindow().setLayout(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
    }

    public static AssignTaskDialog show(Context context, String title, List<UserRealm> list, String ok, String cancel, Drawable icon,
                                        final OnClickListener cancelListener, boolean cancelable) {
        final AssignTaskDialog dialog = new AssignTaskDialog(context);

        View view = initView(context, title, list, ok, cancel, icon, cancelable, cancelListener, dialog);
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

    public static AssignTaskDialog show(Context context, String title, List<UserRealm> list, String ok, String cancel, int iconId,
                                        final OnClickListener cancelListener, boolean cancelable) {
        Drawable drawable = context.getResources().getDrawable(iconId);
        return show(context, title, list, ok, cancel, drawable, cancelListener, cancelable);
    }

    public interface OnClickListener {
        public void onOkClick();

        public void onCancelClick();
        public void onItemClick(UserRealm data,int position);
        public void onDismiss();
    }


    private static View initView(Context context, String title, List<UserRealm> list, String ok, String cancel, Drawable icon, boolean cancelable,
                                 final OnClickListener clickListener, final Dialog dialog) {
        View rootView = LayoutInflater.from(context).inflate(R.layout.layout_assign_task_dialog, null);
        TextView tvTitle = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_title);
        ListView listView = (ListView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_msg);
        TextView tvPositive = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_positive);
        ImageView tvNegative = (ImageView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_negative);
        WindowManager windowManager = (WindowManager) context
                .getSystemService(Context.WINDOW_SERVICE);
        Display display= windowManager.getDefaultDisplay();
        if (!list.isEmpty()) {
            final DialogAssignTaskAdapter assignTaskAdapter=new DialogAssignTaskAdapter(context,listView,list);
            listView.setAdapter(assignTaskAdapter);
            if (list.size() >= 4) {
                LinearLayout.LayoutParams params = (LinearLayout.LayoutParams) listView
                        .getLayoutParams();
                params.height = (display.getHeight() - ScreenUtils.getStatusBarHeight(context) - ScreenUtils.dp2px(context, 50)) / 2;
                listView.setLayoutParams(params);
            }
            listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                     assignTaskAdapter.setSelectPosition(position);
                    if (clickListener != null) {
                        clickListener.onItemClick(assignTaskAdapter.getItem(position),position);
                    }
                    //dialog.dismiss();
                }
            });
        } else {
            listView.setVisibility(View.GONE);
            //dividerHorizontal.setVisibility(View.GONE);
        }
        if (!TextUtils.isEmpty(title)) {
            tvTitle.setVisibility(View.VISIBLE);
            tvTitle.setText(title);
        }else {
            tvTitle.setVisibility(View.GONE);
        }

        if (!TextUtils.isEmpty(ok)) {
            tvPositive.setText(ok);
        } else {
            tvPositive.setVisibility(View.GONE);

        }

        tvPositive.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (clickListener != null) {
                    clickListener.onOkClick();
                }
                dialog.dismiss();
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
        private List<UserRealm> list;
        private boolean cancelable;
        private OnClickListener clickListener;
        private int iconId;
        private Drawable icon;
        private Dialog dialog;

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

        public Builder setList(List<UserRealm> list) {
            this.list = list;
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

        public AssignTaskDialog create() {
            if (iconId != 0) {
                return AssignTaskDialog.show(context, title, list, ok, cancel, iconId, clickListener, cancelable);
            } else if (icon != null) {
                return AssignTaskDialog.show(context, title, list, ok, cancel, icon, clickListener, cancelable);
            } else {
                return AssignTaskDialog.show(context, title, list, ok, cancel, null, clickListener, cancelable);
            }
        }
    }


}
