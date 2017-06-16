package com.example.prernapadhee.wavesoft;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class Main5Activity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main5);

        if(SharedPrefManager.getInstance(this).isLoggedIn()){
            finish();
            Intent i= new Intent(this, Main3Activity.class);
            startActivity(i);
            return;
        }
    }

    public void login(View view){
        Intent intent = new Intent(this, Main2Activity.class);
        startActivity(intent);
    }
    public void signup(View view){
        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
    }
}
