package com.qidu.chat.activity.room

import android.os.Bundle
import android.support.v4.app.Fragment
import android.support.v7.app.AppCompatActivity
import com.qidu.chat.R
import com.qidu.chat.fragment.chatroom.list.RoomListFragment
import kotlinx.android.synthetic.main.activity_room.*

class RoomActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_room)
        setSupportActionBar(toolbar)
        supportActionBar?.setDisplayHomeAsUpEnabled(true)
        supportActionBar?.setDisplayShowHomeEnabled(true)

        val extras = intent.extras
        val roomListFragment = RoomListFragment.newInstance(extras.getInt("actionId"),
                extras.getString("roomId"),
                extras.getString("roomType"),
                extras.getString("hostname"),
                extras.getString("token"),
                extras.getString("userId"))

        addFragment(roomListFragment, "roomListFragment")
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressed()
        return true
    }

    private fun addFragment(fragment: Fragment, tag: String) {
        supportFragmentManager.beginTransaction()
                .add(R.id.fragment_container, fragment, tag)
                .commit()
    }
}