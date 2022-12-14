/****** Object:  Table [dbo].[partidasAutomotriz]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[partidasAutomotriz](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fraccion] [varchar](8) NULL,
	[numero] [varchar](3) NULL,
	[valorComercial] [decimal](18, 2) NULL,
	[valorDolares] [decimal](18, 2) NULL,
	[cantidadUMC] [decimal](18, 6) NULL,
	[umc] [varchar](5) NULL,
	[cantidadUMT] [decimal](18, 6) NULL,
	[umt] [varchar](5) NULL,
	[paisOrigen] [varchar](5) NULL,
	[paisComprador] [varchar](5) NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_partidasAutomotriz] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
