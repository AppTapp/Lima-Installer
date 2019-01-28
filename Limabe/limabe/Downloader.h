#import <Foundation/Foundation.h>
@protocol DownloaderDelegate;
@interface Downloader : NSObject {
    id <DownloaderDelegate> delegate;
    NSString* strFileNameWithPath;
    NSURLConnection* connection;
    CGFloat floatTotalData;
    CGFloat floatReceivedData;
}
@property(nonatomic, retain) NSString* strFileNameWithPath;
@property(nonatomic, retain) id <DownloaderDelegate> delegate;
@end