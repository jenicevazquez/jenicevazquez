/****** Object:  Table [dbo].[covesrfc]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[covesrfc](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[rfc] [varchar](50) NULL,
	[cove_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_rfccoves] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
