#pragma once
#include <string>
#include <Kinect.h>
#include <vector>
#include <opencv2\opencv.hpp>
void ini_OutputToFile();
void OutputToFile();
//extern vector<OutputToFile> Data;
//定义帧数类
class NumberOfFrames
{
public:
	void GetTimes(const int Data);
	int Times;
};

//定义文件输出类
//class OutputToFile
//{
//public:
//	char *Position[25];
//	float X, Y;
//	void ini_OutputToFile();//初始化
//	void DataToVector(float X, float Y);//将数据放到vector中
//};