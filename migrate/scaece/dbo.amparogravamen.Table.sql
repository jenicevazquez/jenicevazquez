/****** Object:  Table [dbo].[amparogravamen]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[amparogravamen](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[valorMercancia] [decimal](18, 2) NULL,
	[montoIGI] [decimal](18, 2) NULL,
	[gravamen_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_amparogravamen] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
