#include "Data_Acquisition.h"
#include "Data_Processing.h"
#include <iostream>
extern std::vector<float> Data_X;
extern std::vector<float> Data_Y;
extern std::vector<float> Data_Z;
using namespace std;
//const char* path;
int frame_num = 0;

/// 初始化kinect函数
HRESULT CBodyBasics::InitializeDefaultSensor()
{

	//用于判断每次读取操作的成功与否
	HRESULT hr;

	//搜索kinect
	hr = GetDefaultKinectSensor(&m_pKinectSensor);
	if (FAILED(hr)){
		return hr;
	}

	//找到kinect设备
	if (m_pKinectSensor)
	{
		// Initialize the Kinect and get coordinate mapper and the body reader
		IBodyFrameSource* pBodyFrameSource = NULL;//读取骨架
		IDepthFrameSource* pDepthFrameSource = NULL;//读取深度信息
		IBodyIndexFrameSource* pBodyIndexFrameSource = NULL;//读取背景二值图

		//打开kinect
		hr = m_pKinectSensor->Open();
		 
		//坐标映射
		if (SUCCEEDED(hr))
		{
			hr = m_pKinectSensor->get_CoordinateMapper(&m_pCoordinateMapper);
		}

		//身体骨架
		if (SUCCEEDED(hr))
		{
			hr = m_pKinectSensor->get_BodyFrameSource(&pBodyFrameSource);
		}
		//读取身体骨架
		if (SUCCEEDED(hr))
		{
			hr = pBodyFrameSource->OpenReader(&m_pBodyFrameReader);
		}

		//深度frame
		if (SUCCEEDED(hr)){
			hr = m_pKinectSensor->get_DepthFrameSource(&pDepthFrameSource);
		}
		//读取深度
		if (SUCCEEDED(hr)){
			hr = pDepthFrameSource->OpenReader(&m_pDepthFrameReader);
		}

		//身体二值frame
		if (SUCCEEDED(hr)){
			hr = m_pKinectSensor->get_BodyIndexFrameSource(&pBodyIndexFrameSource);
		}

		if (SUCCEEDED(hr)){
			hr = pBodyIndexFrameSource->OpenReader(&m_pBodyIndexFrameReader);
		}

		SafeRelease(pBodyFrameSource);
		SafeRelease(pDepthFrameSource);
		SafeRelease(pBodyIndexFrameSource);
	}

	if (!m_pKinectSensor || FAILED(hr))
	{
		std::cout << "Kinect initialization failed!" << std::endl;
		return E_FAIL;
	}

	//skeletonImg,用于画骨架、背景二值图的MAT
	skeletonImg.create(cDepthHeight, cDepthWidth, CV_8UC3);
	skeletonImg.setTo(0);

	//depthImg,用于画深度信息的MAT
	depthImg.create(cDepthHeight, cDepthWidth, CV_8UC1);
	depthImg.setTo(0);

	return hr;
}


/// 主要处理函数
//double* CBodyBasics::Update(double *array)
//void CBodyBasics::Update()
double* CBodyBasics::Update(double *array)
{
	
	//每次先清空skeletonImg
	skeletonImg.setTo(0);

	//如果丢失了kinect，则不继续操作
	if (!m_pBodyFrameReader)
	{
		exit(1);
	}
	IBodyFrame* pBodyFrame = NULL;//骨架信息
	IDepthFrame* pDepthFrame = NULL;//深度信息
	IBodyIndexFrame* pBodyIndexFrame = NULL;//背景二值图

	//记录每次操作的成功与否
	HRESULT hr = S_OK;

	//---------------------------------------获取背景二值图并显示---------------------------------
	if (SUCCEEDED(hr)){
		hr = m_pBodyIndexFrameReader->AcquireLatestFrame(&pBodyIndexFrame);//获得背景二值图信息
	}
	if (SUCCEEDED(hr)){
		BYTE *bodyIndexArray = new BYTE[cDepthHeight * cDepthWidth];//背景二值图是8为uchar
		pBodyIndexFrame->CopyFrameDataToArray(cDepthHeight * cDepthWidth, bodyIndexArray);

		//把背景二值图画到MAT里
		uchar* skeletonData = (uchar*)skeletonImg.data;
		for (int j = 0; j < cDepthHeight * cDepthWidth; ++j){
			*skeletonData = bodyIndexArray[j]; ++skeletonData;
			*skeletonData = bodyIndexArray[j]; ++skeletonData;
			*skeletonData = bodyIndexArray[j]; ++skeletonData;
		}
		delete[] bodyIndexArray;
	}
	SafeRelease(pBodyIndexFrame);//必须要释放，否则之后无法获得新的frame数据

	//-----------------------获取深度数据并显示--------------------------
	if (SUCCEEDED(hr)){
		hr = m_pDepthFrameReader->AcquireLatestFrame(&pDepthFrame);//获得深度数据
	}
	if (SUCCEEDED(hr)){
		UINT16 *depthArray = new UINT16[cDepthHeight * cDepthWidth];//深度数据是16位unsigned int
		pDepthFrame->CopyFrameDataToArray(cDepthHeight * cDepthWidth, depthArray);

		//把深度数据画到MAT中
		uchar* depthData = (uchar*)depthImg.data;
		for (int j = 0; j < cDepthHeight * cDepthWidth; ++j){
			*depthData = depthArray[j];
			++depthData;
		}
		delete[] depthArray;
	}
	SafeRelease(pDepthFrame);//必须要释放，否则之后无法获得新的frame数据
	imshow("深度", depthImg);
	cv::waitKey(5);
	//-----------------------------获取骨架并显示----------------------------
	if (SUCCEEDED(hr)){
		hr = m_pBodyFrameReader->AcquireLatestFrame(&pBodyFrame);//获取骨架信息
	}
	if (SUCCEEDED(hr))
	{
		IBody* ppBodies[BODY_COUNT] = { 0 };//每一个IBody可以追踪一个人，总共可以追踪六个人

		if (SUCCEEDED(hr))
		{
			//把kinect追踪到的人的信息，分别存到每一个IBody中
			hr = pBodyFrame->GetAndRefreshBodyData(_countof(ppBodies), ppBodies);//_countof(ppBodies)计算个数
		}

		if (SUCCEEDED(hr))
		{
			//对每一个IBody，我们找到他的骨架信息，并且画出来
			//ProcessBody(BODY_COUNT, ppBodies);
			//记录操作结果是否成功
			char image_name[30];
			HRESULT hr;
			//path = "E:\\Data\\right\\right.bmp";

			//对于每一个IBody
			for (int i = 0; i < BODY_COUNT; ++i)
			{
				IBody* pBody = ppBodies[i];
				if (pBody)
				{
					BOOLEAN bTracked = false;
					hr = pBody->get_IsTracked(&bTracked);

					if (SUCCEEDED(hr) && bTracked)
					{
						Joint joints[JointType_Count];//存储关节点类
						HandState leftHandState = HandState_Unknown;//左手状态
						HandState rightHandState = HandState_Unknown;//右手状态

						//获取左右手状态
						pBody->get_HandLeftState(&leftHandState);
						pBody->get_HandRightState(&rightHandState);

						//存储深度坐标系中的关节点位置
						DepthSpacePoint *depthSpacePosition = new DepthSpacePoint[_countof(joints)];

						//获得关节点类
						hr = pBody->GetJoints(_countof(joints), joints);
						if (SUCCEEDED(hr))
						{
							for (int j = 0; j < _countof(joints); ++j)
							{
								//将关节点坐标从摄像机坐标系 转到 深度坐标系（424*512）
								m_pCoordinateMapper->MapCameraPointToDepthSpace(joints[j].Position, &depthSpacePosition[j]);
							}
						/*	static int h = 1;
							static double a, b, d, c, e, f;
							for (int i = 0; i < 25; ++i)
							{
								if (i % 25 == 7 || i % 25 == 11)
								{
									if (h ==1 && i % 25 == 7)
									{
										a = joints[i].Position.X;
										b = joints[i].Position.Y;
										c = joints[i].Position.Z;
										h++;
									}
									else if (h > 1 && i % 25 == 11) 
									{
										d = joints[i].Position.X;
										e = joints[i].Position.Y;
										f = joints[i].Position.Z;
										//cout << d - a << " ";
										//cout << e - b << " ";
										//cout << f - c << endl;
										array[0] = (d - a) * 10;
										array[1] = (e - b) * 10;
										array[2] = (f - c) * 10;
										//cout << array[0] << " ";
										//cout << array[1] << " ";
										//cout << array[2] << endl;
									}
								}
							}
							*/
							static int h = 1;
							static double a, b, c, d, e, f;
							for (int i = 0; i < 25; ++i)
							{
								if (i % 25 == 11)
								{
									if (h == 1)
									{
										a = joints[i].Position.X;
										b = joints[i].Position.Y;
										c = joints[i].Position.Z;
										if (a == NULL && b == NULL && c == NULL) break;
										h++;
									}
									else if (h > 1)
									{
										d = joints[i].Position.X;
										e = joints[i].Position.Y;
										f = joints[i].Position.Z;
								//		array[0] = (d - a);
								//		array[1] = (e - b);
								//		array[2] = (f - c);
									}
								}
							}
							array[0] = (d - a) * 30;
							array[1] = (e - b) * 28;
							array[2] = (f - c) * -50;
							/*
							static int h = 1;
							static double a, b, c, d, e, f, g, j, l;
							for (int i = 0; i < 25; ++i)
							{
								if (h == 1)
								{
									if (i % 25 == 7)
									{
										a = joints[i].Position.X;
										b = joints[i].Position.Y;
										c = joints[i].Position.Z;
									}
									else if (i % 25 == 11)
									{
										d = joints[i].Position.X - a;
										e = joints[i].Position.Y - b;
										f = joints[i].Position.Z - c;
									}
									h++;
								}
								else if (h > 1 && i % 25 == 11)
								{
									g = joints[i].Position.X - a - d;
									j = joints[i].Position.Y - b - e;
									l = joints[i].Position.Z - c - f;
									array[0] = g;
									array[1] = h;
									array[2] = l;
								}
							}
							*/

							for (int k = 0; k < 25; k++)//将数据保存到vector中
							{
								//Data_X.push_back(depthSpacePosition[k].X);
								//Data_Y.push_back(depthSpacePosition[k].Y);
								Data_X.push_back(joints[k].Position.X);
								Data_Y.push_back(joints[k].Position.Y);
								Data_Z.push_back(joints[k].Position.Z);

							}

							//------------------------hand state left-------------------------------
							DrawHandState(depthSpacePosition[JointType_HandLeft], leftHandState);
							DrawHandState(depthSpacePosition[JointType_HandRight], rightHandState);
							array[3] = rightHandState;
							array[4] = leftHandState;

							//---------------------------body-------------------------------
							DrawBone(joints, depthSpacePosition, JointType_Head, JointType_Neck);
							DrawBone(joints, depthSpacePosition, JointType_Neck, JointType_SpineShoulder);
							DrawBone(joints, depthSpacePosition, JointType_SpineShoulder, JointType_SpineMid);
							DrawBone(joints, depthSpacePosition, JointType_SpineMid, JointType_SpineBase);
							DrawBone(joints, depthSpacePosition, JointType_SpineShoulder, JointType_ShoulderRight);
							DrawBone(joints, depthSpacePosition, JointType_SpineShoulder, JointType_ShoulderLeft);
							DrawBone(joints, depthSpacePosition, JointType_SpineBase, JointType_HipRight);
							DrawBone(joints, depthSpacePosition, JointType_SpineBase, JointType_HipLeft);

							// -----------------------Right Arm ------------------------------------ 
							DrawBone(joints, depthSpacePosition, JointType_ShoulderRight, JointType_ElbowRight);
							DrawBone(joints, depthSpacePosition, JointType_ElbowRight, JointType_WristRight);
							DrawBone(joints, depthSpacePosition, JointType_WristRight, JointType_HandRight);
							DrawBone(joints, depthSpacePosition, JointType_HandRight, JointType_HandTipRight);
							DrawBone(joints, depthSpacePosition, JointType_WristRight, JointType_ThumbRight);

							//----------------------------------- Left Arm--------------------------
							DrawBone(joints, depthSpacePosition, JointType_ShoulderLeft, JointType_ElbowLeft);
							DrawBone(joints, depthSpacePosition, JointType_ElbowLeft, JointType_WristLeft);
							DrawBone(joints, depthSpacePosition, JointType_WristLeft, JointType_HandLeft);
							DrawBone(joints, depthSpacePosition, JointType_HandLeft, JointType_HandTipLeft);
							DrawBone(joints, depthSpacePosition, JointType_WristLeft, JointType_ThumbLeft);

							// ----------------------------------Right Leg--------------------------------
							DrawBone(joints, depthSpacePosition, JointType_HipRight, JointType_KneeRight);
							DrawBone(joints, depthSpacePosition, JointType_KneeRight, JointType_AnkleRight);
							DrawBone(joints, depthSpacePosition, JointType_AnkleRight, JointType_FootRight);

							// -----------------------------------Left Leg---------------------------------
							DrawBone(joints, depthSpacePosition, JointType_HipLeft, JointType_KneeLeft);
							DrawBone(joints, depthSpacePosition, JointType_KneeLeft, JointType_AnkleLeft);
							DrawBone(joints, depthSpacePosition, JointType_AnkleLeft, JointType_FootLeft);
						}
						delete[] depthSpacePosition;
					}
				}
			}
			cv::imshow("关节", skeletonImg);
			sprintf_s(image_name, "%s%d%s", "e:\\result\\image", ++frame_num, ".jpg");

			cv::imwrite(image_name, skeletonImg);
			cv::waitKey(5);
		}

		for (int i = 0; i < _countof(ppBodies); ++i)
		{
			SafeRelease(ppBodies[i]);//释放所有
		}
	}
	SafeRelease(pBodyFrame);//必须要释放，否则之后无法获得新的frame数据
	return array;
}

/// Handle new body data
void CBodyBasics::ProcessBody(int nBodyCount, IBody** ppBodies)
{
	//记录操作结果是否成功
	char image_name[30];
	HRESULT hr;
	//path = "E:\\Data\\right\\right.bmp";

	//对于每一个IBody
	for (int i = 0; i < nBodyCount; ++i)
	{
		IBody* pBody = ppBodies[i];
		if (pBody)
		{
			BOOLEAN bTracked = false;
			hr = pBody->get_IsTracked(&bTracked);

			if (SUCCEEDED(hr) && bTracked)
			{
				Joint joints[JointType_Count];//存储关节点类
				HandState leftHandState = HandState_Unknown;//左手状态
				HandState rightHandState = HandState_Unknown;//右手状态

				//获取左右手状态
				pBody->get_HandLeftState(&leftHandState);
				pBody->get_HandRightState(&rightHandState);

				//存储深度坐标系中的关节点位置
				DepthSpacePoint *depthSpacePosition = new DepthSpacePoint[_countof(joints)];

				//获得关节点类
				hr = pBody->GetJoints(_countof(joints), joints);
				if (SUCCEEDED(hr))
				{
					for (int j = 0; j < _countof(joints); ++j)
					{
						//将关节点坐标从摄像机坐标系 转到 深度坐标系（424*512）
						m_pCoordinateMapper->MapCameraPointToDepthSpace(joints[j].Position, &depthSpacePosition[j]);
					}					
					for (int k = 0; k < 25; k++)//将数据保存到vector中
					{
						//Data_X.push_back(depthSpacePosition[k].X);
						//Data_Y.push_back(depthSpacePosition[k].Y);
						Data_X.push_back(joints[k].Position.X);
						Data_Y.push_back(joints[k].Position.Y);
						Data_Z.push_back(joints[k].Position.Z);
						
					}

					//------------------------hand state left-------------------------------
					//DrawHandState(depthSpacePosition[JointType_HandLeft], leftHandState);
					//DrawHandState(depthSpacePosition[JointType_HandRight], rightHandState);

					//---------------------------body-------------------------------
					DrawBone(joints, depthSpacePosition, JointType_Head, JointType_Neck);
					DrawBone(joints, depthSpacePosition, JointType_Neck, JointType_SpineShoulder);
					DrawBone(joints, depthSpacePosition, JointType_SpineShoulder, JointType_SpineMid);
					DrawBone(joints, depthSpacePosition, JointType_SpineMid, JointType_SpineBase);
					DrawBone(joints, depthSpacePosition, JointType_SpineShoulder, JointType_ShoulderRight);
					DrawBone(joints, depthSpacePosition, JointType_SpineShoulder, JointType_ShoulderLeft);
					DrawBone(joints, depthSpacePosition, JointType_SpineBase, JointType_HipRight);
					DrawBone(joints, depthSpacePosition, JointType_SpineBase, JointType_HipLeft);

					// -----------------------Right Arm ------------------------------------ 
					DrawBone(joints, depthSpacePosition, JointType_ShoulderRight, JointType_ElbowRight);
					DrawBone(joints, depthSpacePosition, JointType_ElbowRight, JointType_WristRight);
					DrawBone(joints, depthSpacePosition, JointType_WristRight, JointType_HandRight);
					DrawBone(joints, depthSpacePosition, JointType_HandRight, JointType_HandTipRight);
					DrawBone(joints, depthSpacePosition, JointType_WristRight, JointType_ThumbRight);

					//----------------------------------- Left Arm--------------------------
					DrawBone(joints, depthSpacePosition, JointType_ShoulderLeft, JointType_ElbowLeft);
					DrawBone(joints, depthSpacePosition, JointType_ElbowLeft, JointType_WristLeft);
					DrawBone(joints, depthSpacePosition, JointType_WristLeft, JointType_HandLeft);
					DrawBone(joints, depthSpacePosition, JointType_HandLeft, JointType_HandTipLeft);
					DrawBone(joints, depthSpacePosition, JointType_WristLeft, JointType_ThumbLeft);

					// ----------------------------------Right Leg--------------------------------
					DrawBone(joints, depthSpacePosition, JointType_HipRight, JointType_KneeRight);
					DrawBone(joints, depthSpacePosition, JointType_KneeRight, JointType_AnkleRight);
					DrawBone(joints, depthSpacePosition, JointType_AnkleRight, JointType_FootRight);

					// -----------------------------------Left Leg---------------------------------
					DrawBone(joints, depthSpacePosition, JointType_HipLeft, JointType_KneeLeft);
					DrawBone(joints, depthSpacePosition, JointType_KneeLeft, JointType_AnkleLeft);
					DrawBone(joints, depthSpacePosition, JointType_AnkleLeft, JointType_FootLeft);
				}
				delete[] depthSpacePosition;
			}
		}
	}
	cv::imshow("关节", skeletonImg);
	sprintf_s(image_name, "%s%d%s", "e:\\result\\image", ++frame_num, ".jpg");

	cv::imwrite(image_name, skeletonImg);
	cv::waitKey(5);
}

//画手的状态
void CBodyBasics::DrawHandState(const DepthSpacePoint depthSpacePosition, HandState handState)
{
	//给不同的手势分配不同颜色
	CvScalar color;
	switch (handState){
	case HandState_Open:
		color = cvScalar(255, 0, 0);
		break;
	case HandState_Closed:
		color = cvScalar(0, 255, 0);
		break;
	case HandState_Lasso:
		color = cvScalar(0, 0, 255);
		break;
	default://没有确定的手势，就不画
		return;
	}

	circle(skeletonImg,
		cvPoint(depthSpacePosition.X, depthSpacePosition.Y),
		20, color, -1);
}


/// Draws one bone of a body (joint to joint)
void CBodyBasics::DrawBone(const Joint* pJoints, const DepthSpacePoint* depthSpacePosition, JointType joint0, JointType joint1)
{
	TrackingState joint0State = pJoints[joint0].TrackingState;
	TrackingState joint1State = pJoints[joint1].TrackingState;

	// If we can't find either of these joints, exit
	if ((joint0State == TrackingState_NotTracked) || (joint1State == TrackingState_NotTracked))
	{
		return;
	}

	// Don't draw if both points are inferred
	if ((joint0State == TrackingState_Inferred) && (joint1State == TrackingState_Inferred))
	{
		return;
	}

	CvPoint p1 = cvPoint(depthSpacePosition[joint0].X, depthSpacePosition[joint0].Y),
		p2 = cvPoint(depthSpacePosition[joint1].X, depthSpacePosition[joint1].Y);

	// We assume all drawn bones are inferred unless BOTH joints are tracked
	if ((joint0State == TrackingState_Tracked) && (joint1State == TrackingState_Tracked))
	{
		//非常确定的骨架，用白色直线
		line(skeletonImg, p1, p2, cvScalar(255, 255, 255));
	}
	else
	{
		//不确定的骨架，用红色直线
		line(skeletonImg, p1, p2, cvScalar(0, 0, 255));
	}
}


/// Constructor
CBodyBasics::CBodyBasics() :
m_pKinectSensor(NULL),
m_pCoordinateMapper(NULL),
m_pBodyFrameReader(NULL){}

/// Destructor
CBodyBasics::~CBodyBasics()
{
	SafeRelease(m_pBodyFrameReader);
	SafeRelease(m_pCoordinateMapper);

	if (m_pKinectSensor)
	{
		m_pKinectSensor->Close();
	}
	SafeRelease(m_pKinectSensor);
}