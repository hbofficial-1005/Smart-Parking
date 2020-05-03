package kz.qrscan.qrscanner.Activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import kz.qrscan.qrscanner.R;

public class SignUp extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);
    }
    public void onClick(View view){
        Intent intent= new Intent(this, WelcomeActivity.class);
        startActivity(intent);
    }
}
