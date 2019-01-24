
package chat.rocket.android.widget;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.luck.picture.lib.decoration.GridSpacingItemDecoration;

import java.util.ArrayList;
import java.util.List;

import chat.rocket.android.widget.layouthelper.MessageExtraActionListAdapter;
import chat.rocket.android.widget.message.MessageExtraActionItemPresenter;

/**
 * 聊天键盘功能界面
 *
 * @author kymjs (http://www.kymjs.com/) on 7/6/15.
 */
public class ChatFunctionFragment extends Fragment {
    private List<MessageExtraActionItemPresenter> actionItems=new ArrayList<>();

    public static ChatFunctionFragment create(
            List<MessageExtraActionItemPresenter> actionItems) {
        ChatFunctionFragment fragment = new ChatFunctionFragment();
        fragment.setActionItems(actionItems);
        return fragment;
    }

    public void setActionItems(List<MessageExtraActionItemPresenter> actionItems) {
        this.actionItems = actionItems;
    }

    private View mView;

    @Override
    public View onCreateView(LayoutInflater layoutInflater, ViewGroup viewGroup, Bundle bundle) {
        mView=layoutInflater.inflate(R.layout.dialog_message_extra_action_picker,viewGroup,false);
        return mView;
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        initWidget(view);
    }
    private MessageExtraActionListAdapter adapter;
    protected void initWidget(View parentView) {
        adapter = new MessageExtraActionListAdapter(actionItems);
        adapter.setOnItemClickListener(new MessageExtraActionListAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(int itemId) {
                /*if (listener != null) {
                    listener.selectedFunction(itemId);
                }*/
                callbackOnItemSelected(itemId);
            }
        });
        GridLayoutManager gridLayoutManager=new GridLayoutManager(getActivity(),4);
        RecyclerView recyclerView =
                (RecyclerView) mView.findViewById(R.id.message_extra_action_listview);
        recyclerView.setLayoutManager(gridLayoutManager);
        recyclerView.addItemDecoration(new GridSpacingItemDecoration(
                4, 30, false));
        recyclerView.setAdapter(adapter);
    }



    private void callbackOnItemSelected(int itemId) {
        final Fragment fragment = getTargetFragment();
        if (fragment instanceof ChatFunctionFragment.Callback) {
            ((ChatFunctionFragment.Callback) fragment).onItemSelected(itemId);
        }
    }

    public interface Callback {
        void onItemSelected(int itemId);
    }
}
